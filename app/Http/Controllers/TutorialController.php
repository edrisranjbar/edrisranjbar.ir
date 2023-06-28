<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index()
    {
        $tutorials = Tutorial::all();
        return view('admin.tutorials.index', compact('tutorials'));
    }

    public function create()
    {
        return view('admin.tutorials.create');
    }

    public function store(Request $request)
    {
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
        Tutorial::create($validatedData);
        return redirect()->route('tutorials.index')->with('success', 'دوره آموزشی جدید با موفقیت ذخیره شد.');
    }

    public function edit(int $id)
    {
        $tutorial = Tutorial::findOrFail($id);
        return view('admin.tutorials.create', compact('tutorial'));
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
