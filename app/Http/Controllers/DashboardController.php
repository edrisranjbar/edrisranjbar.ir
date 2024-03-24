<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $studentsCount = User::all()->count();
        $postsCount = Post::all()->count();
        $comments = Comment::orderBy('created_at', 'desc')->paginate(30);
        return view('admin.index', compact('studentsCount', 'postsCount', 'comments'));
    }
}
