<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\CourseSection;
use App\Models\Tutorial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorialController extends Controller
{

    private array $statusOptions;

    public function __construct()
    {
        $this->statusOptions = ['published' => 'عمومی', 'private' => 'خصوصی', 'draft' => 'پیش‌نویس'];
    }

    public function publicPage()
    {
        $tutorials = Tutorial::all();
        return view('tutorials.index', compact('tutorials'));
    }

    public function index()
    {
        $tutorials = Tutorial::all();
        return view('admin.tutorials.index', compact('tutorials'));
    }

    public function create()
    {
        $tutors = Admin::all();
        $statusOptions = $this->statusOptions;
        return view('admin.tutorials.createOrEdit', compact('tutors', 'statusOptions'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'tutor' => 'required|exists:admins,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'status' => 'required|in:published,private,draft',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:20048',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif|max:20048',
            'slug' => 'required|string|max:50|unique:tutorials,slug',
            'sections' => 'string|required',
            'good_for_items' => 'nullable',
            'bad_for_items' => 'nullable'
        ]);

        // Store the actual thumbnail if exists
        if ($request->hasFile('thumbnail')) {
            $request->thumbnail->store('public/upload');
            $validatedData['thumbnail'] = $request->thumbnail->hashName();
        }

        if ($request->hasFile('poster')) {
            $request->poster->store('public/upload');
            $validatedData['poster'] = $request->poster->hashName();
        }

        $tutorial = Tutorial::create([
            'title' => $validatedData['title'],
            'price' => $validatedData['price'],
            'duration' => $validatedData['duration'],
            'tutor' => $validatedData['tutor'],
            'description' => $validatedData['description'],
            'short_description' => $validatedData['short_description'],
            'status' => $validatedData['status'],
            'thumbnail' => $validatedData['thumbnail'],
            'poster' => $validatedData['poster'],
            'slug' => $validatedData['slug'],
            'good_for_items' => $validatedData['good_for_items'],
            'bad_for_items' => $validatedData['bad_for_items']
        ]);

        $sectionsArray = explode(",", $validatedData['sections']);
        foreach ($sectionsArray as $sectionName) {
            $existingSection = CourseSection::where(['title' => $sectionName, 'tutorial_id' => $tutorial->id])
                ->first();
            if (!$existingSection) {
                CourseSection::create([
                    'title' => $sectionName,
                    'tutorial_id' => $tutorial->id
                ]);
            }
        }
        return redirect()->route('tutorials.index')->with('success', 'دوره آموزشی جدید با موفقیت ذخیره شد.');
    }

    public function edit(int $id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $tutors = Admin::all();
        $statusOptions = $this->statusOptions;
        return view('admin.tutorials.createOrEdit', compact('tutorial', 'tutors', 'statusOptions'));
    }

    public function update(Request $request, int $id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'price' => 'required|integer|min:0',
            'tutor' => 'required|exists:admins,id',
            'description' => 'required',
            'short_description' => 'nullable|max:255',
            'status' => 'required|in:published,private,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048',
            'sections' => 'string|required',
            'good_for_items' => 'nullable',
            'bad_for_items' => 'nullable'
        ]);

        if ($request->hasFile('thumbnail')) {
            $request->thumbnail->store('public/upload');
            $validatedData['thumbnail'] = $request->thumbnail->hashName();
        }
        if ($request->hasFile('poster')) {
            $request->poster->store('public/upload');
            $validatedData['poster'] = $request->poster->hashName();
        }

        $existingSections = $tutorial->sections->pluck('title')->toArray();
        $sectionsArray = explode(",", $validatedData['sections']);
        $newSections = array_diff($sectionsArray, $existingSections);
        foreach ($newSections as $sectionName) {
            CourseSection::create([
                'title' => $sectionName,
                'tutorial_id' => $tutorial->id
            ]);
        }
        // Update existing sections
        $updatedSections = array_intersect($sectionsArray, $existingSections);
        foreach ($updatedSections as $sectionName) {
            $section = $tutorial->sections->where('title', $sectionName)->where('tutorial_id', $tutorial->id)->first();
            if ($section) {
                $section->update(['title' => $sectionName]);
            }
        }
        // Remove sections that are no longer present
        $removedSections = array_diff($existingSections, $sectionsArray);
        CourseSection::where('title', '=', $removedSections)
            ->where('tutorial_id', '=', $tutorial->id)
            ->delete();
        $tutorial->update($validatedData);
        return redirect()->route('tutorials.index')->with('success', 'دوره آموزشی با موفقیت به روزرسانی شد.');
    }

    public function destroy(int $id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $tutorial->sections()->delete();
        $tutorial->delete();
        return redirect()->route('tutorials.index')->with('success', 'دوره آموزشی با موفقیت حذف شد.');
    }

    public function enroll(Request $request, int $tutorial_id)
    {
        $tutorial = Tutorial::findOrFail($tutorial_id);
        $user = Auth::guard('user')?->user();
        if (!$user) {
            return redirect()->route('user.login');
        }
        if (!$user?->tutorials->contains($tutorial->id)) {
            if ($tutorial->price > 0) {
                $this->payOnlineUsingZarrinpal($tutorial->price, $tutorial->title, $user);
            }
            $user->tutorials()->attach($tutorial->id);
            return redirect()->back()->with('success', 'با موفقیت در دوره ثبت نام شدید!');
        }
        return redirect()->back()->with('error', 'شما در این دوره عضو هستید');
    }

    private function payOnlineUsingZarrinpal(int $price, string $description, User $user)
    {
        $response = zarinpal()
            ->amount($price)
            ->request()
            ->description($description)
            ->callbackUrl("")
            ->email($user->email)
            ->send();

        if (!$response->success()) {
            return $response->error()->message();
        }
        // $response->authority();
        return $response->redirect('');
    }

}
