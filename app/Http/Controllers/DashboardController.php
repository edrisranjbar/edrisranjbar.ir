<?php

namespace App\Http\Controllers;

use AndreasElia\Analytics\Models\PageView;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Couchbase\AnalyticsResult;
use Illuminate\View\View;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    public function index(): View
    {
        $studentsCount = User::all()->count();
        $comments = Comment::orderBy('created_at', 'desc')->paginate(30);
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);
        $postsCount = Post::all()->count();

        // Analytics
        $lastWeekDates = collect(range(6, 0))->map(function ($i) {
            $date = Jalalian::now()->subDays($i);
            return $date->format('l');
        });
        $currentWeekViews = [];
        $currentWeekViewers = [];
        for ($i = 0; $i < 7; $i++) {
            $currentWeekViews[] = PageView::query()->scopes(['filter' => ["day_" . $i]])->count() - array_sum($currentWeekViews);
            $currentWeekViewers[] = PageView::query()->scopes(['filter' => ["day_" . $i]])->groupBy('session')->pluck('session')->count() - array_sum($currentWeekViewers);
        }
        $currentWeekViews = array_reverse($currentWeekViews);
        $currentWeekViewers = array_reverse($currentWeekViewers);
        $totalViews = $currentWeekViews[count($currentWeekViews)-1];
        $totalViewers = $currentWeekViewers[count($currentWeekViewers) - 1];

        return view('admin.index',
            compact(
                'studentsCount',
                'postsCount',
                'comments',
                'totalViewers',
                'totalViews',
                'currentWeekViews',
                'currentWeekViewers',
                'lastWeekDates',
                'posts'
            ));
    }
}
