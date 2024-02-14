<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $studentsCount = User::all()->count();
        return view('admin.index', compact('studentsCount'));
    }
}
