<?php

namespace App\Http\Controllers;

use App\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index()
    {
        $tutorials = Tutorial::all();
        return view('tutorials.index', compact('tutorials'));
    }

    public function create()
    {
        return view('tutorials.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'tutor' => 'required',
            'description' => 'required',
            'status' => 'required|in:public,private,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails');
            $validatedData['thumbnail'] = $thumbnailPath;
        }

        Tutorial::create($validatedData);

        return redirect()->route('tutorials.index')->with('success', 'Tutorial created successfully.');
    }

    public function edit(Tutorial $tutorial)
    {
        return view('tutorials.edit', compact('tutorial'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'tutor' => 'required',
            'description' => 'required',
            'status' => 'required|in:public,private,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails');
            $validatedData['thumbnail'] = $thumbnailPath;
        }

        $tutorial->update($validatedData);

        return redirect()->route('tutorials.index')->with('success', 'Tutorial updated successfully.');
    }

    public function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();

        return redirect()->route('tutorials.index')->with('success', 'Tutorial deleted successfully.');
    }
}
