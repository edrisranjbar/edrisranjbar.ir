<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $studentsCount = User::all()->count();
        return view('admin.index', compact('studentsCount'));
    }
}
