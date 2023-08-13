<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
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
        return view('admin.tutorials.createOrEdit', compact('tutors'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'duration' => 'required|integer|min:0',
            'tutor' => 'required|exists:admins,id',
            'description' => 'nullable|string',
            'status' => 'required|in:public,private,draft',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slug' => 'required|string|max:50|unique:tutorials,slug',
        ]);

        // Store the actual thumbnail if exists
        if ($request->hasFile('thumbnail')) {
            $request->thumbnail->store('public/upload');
            $validatedData['thumbnail'] = $request->thumbnail->hashName();
        }
        Tutorial::create([
            'title' => $validatedData['title'],
            'price' => $validatedData['price'],
            'duration' => $validatedData['duration'],
            'tutor' => $validatedData['tutor'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'thumbnail' => $validatedData['thumbnail'],
            'slug' => $validatedData['slug'],
        ]);
        return redirect()->route('tutorials.index')->with('success', 'دوره آموزشی جدید با موفقیت ذخیره شد.');
    }

    public function edit(int $id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $tutors = Admin::all();
        return view('admin.tutorials.createOrEdit', compact('tutorial', 'tutors'));
    }

    public function update(Request $request, int $id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'price' => 'required|integer|min:0',
            'tutor' => 'required|exists:admins,id',
            'description' => 'required',
            'status' => 'required|in:public,private,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('thumbnail')) {
            $request->thumbnail->store('public/upload');
            $validatedData['thumbnail'] = $request->thumbnail->hashName();
        }
        $tutorial->update($validatedData);
        return redirect()->route('tutorials.index')->with('success', 'دوره آموزشی با موفقیت به روزرسانی شد.');
    }

    public function destroy(int $id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $tutorial->delete();
        return redirect()->route('tutorials.index')->with('success', 'دوره آموزشی با موفقیت حذف شد.');
    }
}
