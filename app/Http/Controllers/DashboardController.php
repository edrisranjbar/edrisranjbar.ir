<?php

namespace App\Http\Controllers;

use AndreasElia\Analytics\Models\PageView;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Couchbase\AnalyticsResult;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $studentsCount = User::all()->count();
        $postsCount = Post::all()->count();
        $comments = Comment::orderBy('created_at', 'desc')->paginate(30);
        $totalViews = PageView::query()->scopes(['filter' => ['today']])->count();
        $totalViewers = PageView::query()
            ->scopes(['filter' => ['today']])
            ->groupBy('session')
            ->pluck('session')
            ->count();
        return view('admin.index',
            compact(
                'studentsCount',
                'postsCount',
                'comments',
                'totalViewers',
                'totalViews'
            ));
    }
}
