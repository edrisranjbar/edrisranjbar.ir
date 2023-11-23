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
}
