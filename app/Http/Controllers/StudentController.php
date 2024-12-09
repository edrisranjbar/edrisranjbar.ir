<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::whereHas('tutorials')->get();
        return view('admin.students.index', compact('students'));
    }
}
