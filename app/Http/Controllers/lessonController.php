<?php

namespace App\Http\Controllers;

use App\Models\CourseSection;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Tutorial;

class lessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::all();
        return view('admin.tutorials.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $tutorials = Tutorial::all();
        $sections = CourseSection::all();
        return view('admin.tutorials.lessons.createOrEdit', compact('tutorials', 'sections'));
    }

    public function edit()
    {
        $tutorials = Tutorial::all();
        $sections = CourseSection::all();
        return view('admin.tutorials.lessons.createOrEdit', compact('tutorials', 'sections'));
    }

    public function store(Request $request)
    {
        $validationRules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'seoTitle' => 'required|string|max:255',
            'seoDescription' => 'nullable|string',
            'slug' => 'nullable|string|max:50',
            'order_id' => 'nullable|integer|min:1|max:1000',
            'status' => 'required|in:public,private,draft',
            'duration' => 'required|integer|min:1',
            'isFree' => 'nullable|in:true,false',
            'file' => 'nullable|file|mimes:zip',
            'video' => 'required|file|mimetypes:video/*',
            'tutorial_id' => 'required|exists:tutorials,id',
            'section_id' => 'required|exists:sections,id',
        ];
        // Handle file uploads
        if ($request->hasFile('file')) {
            $request->file('file')->store('public/upload');
            $validatedData['file_path'] = $request->file->hashName();
        }
        
        // Handle video uploads
        if ($request->hasFile('video')) {
            $request->file('video')->store('public/upload');
            $validatedData['video_path'] = $request->video->hashName();
        }
        $validatedData = $request->validate($validationRules);
        $validatedData['isFree'] = boolval($validatedData['isFree'] ?? false);
        unset($validatedData['file'],$validatedData['video']);
        Lesson::create($validatedData);
        return redirect()->route('lessons.index')->with('success', 'درس با موفقیت اضافه شد.');
    }
}
