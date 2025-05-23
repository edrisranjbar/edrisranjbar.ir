<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\PageView;
use Illuminate\Support\Facades\DB;

class RefreshUniqueVisitorsCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:refresh-unique-visitors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh unique visitors count for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Refreshing unique visitors count...');
        
        // Get all posts with page views
        $postsWithViews = Post::has('pageViews')->get();
        
        $this->info("Found {$postsWithViews->count()} posts with views.");
        
        foreach ($postsWithViews as $post) {
            // Get current views count
            $viewsCount = $post->pageViews()->count();
            
            // Get all page view IPs for this post
            $ipAddresses = $post->pageViews()->distinct('ip_address')->pluck('ip_address');
            
            $this->info("Post ID {$post->id}: {$viewsCount} views, {$ipAddresses->count()} unique visitors");
        }
        
        // Get all generic page views
        $genericPages = PageView::where('page_type', 'route')
            ->select('referrer as path', DB::raw('COUNT(*) as views_count'), DB::raw('COUNT(DISTINCT ip_address) as unique_visitors'))
            ->groupBy('referrer')
            ->get();
            
        $this->info("\nGeneric Pages:");
        foreach ($genericPages as $page) {
            $this->info("Path: {$page->path}, Views: {$page->views_count}, Unique Visitors: {$page->unique_visitors}");
        }
        
        $this->info("\nUnique visitors count refresh completed!");
        
        return Command::SUCCESS;
    }
}
