<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageViewController extends Controller
{
    /**
     * Record a page view for a post
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function recordPostView(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $post->recordView($request);
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Get analytics for all posts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAnalytics(Request $request)
    {
        $period = $request->input('period', 'week');
        $startDate = null;
        $endDate = Carbon::now();
        
        switch ($period) {
            case 'today':
                $startDate = Carbon::today();
                break;
            case 'yesterday':
                $startDate = Carbon::yesterday();
                $endDate = Carbon::today()->subSecond();
                break;
            case 'week':
                $startDate = Carbon::now()->subDays(7);
                break;
            case 'month':
                $startDate = Carbon::now()->subMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->subYear();
                break;
            case 'custom':
                $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subDays(7);
                $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();
                break;
            default:
                $startDate = Carbon::now()->subDays(7);
        }
        
        // Total views
        $totalViews = PageView::forPeriod($startDate, $endDate)->count();
        
        // Unique visitors
        $uniqueVisitors = PageView::forPeriod($startDate, $endDate)->uniqueVisitors()->count();
        
        // Daily views for chart
        $dailyViews = PageView::select(
                DB::raw('DATE(viewed_at) as date'),
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT ip_address) as unique_visitors')
            )
            ->forPeriod($startDate, $endDate)
            ->when($period === 'year', function($query) {
                return $query->groupBy(DB::raw('MONTH(viewed_at)'))
                    ->select(
                        DB::raw('DATE_FORMAT(viewed_at, "%Y-%m-01") as date'),
                        DB::raw('COUNT(*) as views'),
                        DB::raw('COUNT(DISTINCT ip_address) as unique_visitors')
                    );
            }, function($query) {
                return $query->groupBy(DB::raw('DATE(viewed_at)'));
            })
            ->orderBy('date')
            ->get();
            
        // Most viewed posts
        $topPosts = Post::select('posts.*', DB::raw('COUNT(page_views.id) as views_count'))
            ->join('page_views', function($join) {
                $join->on('posts.id', '=', 'page_views.page_id')
                    ->where('page_views.page_type', '=', Post::class);
            })
            ->whereBetween('page_views.viewed_at', [$startDate, $endDate])
            ->groupBy('posts.id')
            ->orderByDesc('views_count')
            ->take(5)
            ->with('category')
            ->get();
        
        return response()->json([
            'totalViews' => $totalViews,
            'uniqueVisitors' => $uniqueVisitors,
            'dailyViews' => $dailyViews,
            'topPosts' => $topPosts,
            'period' => [
                'start' => $startDate->toDateString(),
                'end' => $endDate->toDateString(),
            ]
        ]);
    }
    
    /**
     * Get analytics for a specific post
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function getPostAnalytics(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $period = $request->input('period', 'week');
        $startDate = null;
        $endDate = Carbon::now();
        
        switch ($period) {
            case 'today':
                $startDate = Carbon::today();
                break;
            case 'week':
                $startDate = Carbon::now()->subDays(7);
                break;
            case 'month':
                $startDate = Carbon::now()->subMonth();
                break;
            case 'all':
                $startDate = Carbon::create(2000, 1, 1);
                break;
            default:
                $startDate = Carbon::now()->subDays(7);
        }
        
        // Total views for this post
        $totalViews = $post->pageViews()->forPeriod($startDate, $endDate)->count();
        
        // Unique visitors for this post
        $uniqueVisitors = $post->pageViews()->forPeriod($startDate, $endDate)->uniqueVisitors()->count();
        
        // Daily views for chart
        $dailyViews = $post->pageViews()
            ->select(
                DB::raw('DATE(viewed_at) as date'),
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT ip_address) as unique_visitors')
            )
            ->forPeriod($startDate, $endDate)
            ->groupBy(DB::raw('DATE(viewed_at)'))
            ->orderBy('date')
            ->get();
        
        return response()->json([
            'post' => $post->only('id', 'title', 'slug'),
            'totalViews' => $totalViews,
            'uniqueVisitors' => $uniqueVisitors,
            'dailyViews' => $dailyViews,
            'period' => [
                'start' => $startDate->toDateString(),
                'end' => $endDate->toDateString(),
            ]
        ]);
    }
}
