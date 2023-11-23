<?php

namespace App\Http\Controllers;
use App\Models\Tutorial;
use App\Models\CourseSection;
use Illuminate\Http\Request;

class CourseSectionController extends Controller
{
    public function index()
    {
        $courseSections = CourseSection::with('tutorial')->get();
        return view('admin.tutorials.sections.index', compact('courseSections'));
    }

    public function show(int $id)
    {
        $courseSection = CourseSection::with('tutorial', 'lessons')->findOrFail($id);
        return view('admin.tutorials.sections.show', compact('courseSection'));
    }

    public function create()
    {
        return view('admin.tutorials.sections.createOrEdit');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'tutorial_id' => 'required|exists:tutorials,id',
        ]);
        $tutorialId = $validatedData['tutorial_id'];
        $tutorial = Tutorial::findOrFail($tutorialId);
        $tutorial->sections()->create([
            'title' => $validatedData['title'],
        ]);
        return redirect()->route('courseSections.index')->with('success', 'بخش جدید با موفقیت ایجاد شد');
    }
}
