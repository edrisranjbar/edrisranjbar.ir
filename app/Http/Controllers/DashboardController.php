<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $studentsCount = User::all()->count();
        $postsCount = Post::all()->count();
        return view('admin.index', compact('studentsCount', 'postsCount'));
    }
}
