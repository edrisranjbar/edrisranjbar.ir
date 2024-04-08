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
        $postsCount = Post::all()->count();
        $comments = Comment::orderBy('created_at', 'desc')->paginate(30);


        // Analytics
        
        // Analytics
        $lastWeekDates = collect(range(0, 6))->map(function ($i) {
            $date = Jalalian::now()->subDays($i);
            return $date->format('l');
        });

        // Analytics
        for ($i = 0; $i < 7; $i++) {
            $currentWeekViews[] = PageView::query()->scopes(['filter' => ["day_" . $i]])->count();
            $currentWeekViewers[] = PageView::query()->scopes(['filter' => ["day_" . $i]])
            ->groupBy('session')
            ->pluck('session')->count();
        }

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
                'lastWeekDates'
            ));
    }
}
