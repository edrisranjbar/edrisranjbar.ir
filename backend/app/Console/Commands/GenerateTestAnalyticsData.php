<?php

namespace App\Console\Commands;

use App\Models\PageView;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateTestAnalyticsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-test-analytics-data {days=7 : Number of days to generate data for} {--posts=10 : Number of posts to generate views for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate test analytics data for development and testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get number of days from argument
        $days = (int) $this->argument('days');
        if ($days < 1) {
            $days = 7;
        }
        
        $this->info("Generating test analytics data for the last {$days} days...");
        
        $postsCount = $this->option('posts');
        
        // Get posts to generate views for
        $posts = Post::take($postsCount)->get();
        
        if ($posts->isEmpty()) {
            $this->error('No posts found. Please create some posts first.');
            return 1;
        }
        
        $this->info("Generating views for {$posts->count()} posts...");
        
        // First create a pool of IP addresses to use
        $ipPool = [];
        for ($i = 0; $i < 20; $i++) {
            $ipPool[] = $this->generateRandomIP();
        }
        
        $totalViews = 0;
        $uniqueIPs = [];
        
        // Generate views for each day
        for ($i = 0; $i < $days; $i++) {
            $date = Carbon::now()->subDays($i);
            $viewsForDay = rand(5, 20); // Random number of views per day
            
            for ($j = 0; $j < $viewsForDay; $j++) {
                $post = $posts->random();
                
                // Use an IP from our pool with some randomness to simulate repeat visits
                $ipAddress = $ipPool[array_rand($ipPool)];
                
                // Add to unique IPs
                if (!in_array($ipAddress, $uniqueIPs)) {
                    $uniqueIPs[] = $ipAddress;
                }
                
                PageView::create([
                    'page_type' => Post::class,
                    'page_id' => $post->id,
                    'ip_address' => $ipAddress,
                    'user_agent' => $this->generateRandomUserAgent(),
                    'session_id' => Str::random(40),
                    'country' => $this->getRandomCountry(),
                    'city' => $this->getRandomCity(),
                    'browser' => $this->getRandomBrowser(),
                    'os' => $this->getRandomOS(),
                    'device' => $this->getRandomDevice(),
                    'referrer' => $this->getRandomReferrer(),
                    'viewed_at' => $date->copy()->addMinutes(rand(0, 1440)),
                ]);
                
                $totalViews++;
            }
        }
        
        $this->info("Generated {$totalViews} total views");
        $this->info("Generated " . count($uniqueIPs) . " unique visitors");
        
        // Generate views for home and blog pages
        $this->info("Generating views for generic pages...");
        $genericPages = ['/', '/blog'];
        $genericViewsTotal = 0;
        
        foreach ($genericPages as $page) {
            $genericViewsForPage = rand(10, 30);
            
            for ($j = 0; $j < $genericViewsForPage; $j++) {
                // Use an IP from our pool with some randomness
                $ipAddress = $ipPool[array_rand($ipPool)];
                
                PageView::create([
                    'page_type' => 'route',
                    'page_id' => null,
                    'ip_address' => $ipAddress,
                    'user_agent' => $this->generateRandomUserAgent(),
                    'session_id' => Str::random(40),
                    'country' => $this->getRandomCountry(),
                    'city' => $this->getRandomCity(),
                    'browser' => $this->getRandomBrowser(),
                    'os' => $this->getRandomOS(),
                    'device' => $this->getRandomDevice(),
                    'referrer' => $page,
                    'viewed_at' => Carbon::now()->subDays(rand(0, $days))->addMinutes(rand(0, 1440)),
                ]);
                
                $genericViewsTotal++;
            }
        }
        
        $this->info("Generated {$genericViewsTotal} views for generic pages");
        
        return 0;
    }
    
    /**
     * Generate a random IP address
     */
    private function generateRandomIP()
    {
        return rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);
    }
    
    /**
     * Generate a random user agent
     */
    private function generateRandomUserAgent()
    {
        $browsers = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
        ];
        
        return $browsers[array_rand($browsers)];
    }
    
    /**
     * Get a random country
     */
    private function getRandomCountry()
    {
        $countries = ['United States', 'United Kingdom', 'Canada', 'Germany', 'France', 'Japan', 'Australia', 'Brazil', 'India', 'China'];
        return $countries[array_rand($countries)];
    }
    
    /**
     * Get a random city
     */
    private function getRandomCity()
    {
        $cities = ['New York', 'London', 'Toronto', 'Berlin', 'Paris', 'Tokyo', 'Sydney', 'São Paulo', 'Mumbai', 'Shanghai'];
        return $cities[array_rand($cities)];
    }
    
    /**
     * Get a random browser
     */
    private function getRandomBrowser()
    {
        $browsers = ['Chrome', 'Safari', 'Firefox', 'Edge', 'Opera'];
        return $browsers[array_rand($browsers)];
    }
    
    /**
     * Get a random OS
     */
    private function getRandomOS()
    {
        $os = ['Windows', 'macOS', 'Linux', 'iOS', 'Android'];
        return $os[array_rand($os)];
    }
    
    /**
     * Get a random device
     */
    private function getRandomDevice()
    {
        $devices = ['Desktop', 'Mobile', 'Tablet'];
        return $devices[array_rand($devices)];
    }
    
    /**
     * Get a random referrer
     */
    private function getRandomReferrer()
    {
        $referrers = [
            'https://www.google.com/',
            'https://www.facebook.com/',
            'https://twitter.com/',
            'https://www.linkedin.com/',
            'https://www.reddit.com/',
            'https://www.instagram.com/',
            null,
        ];
        
        return $referrers[array_rand($referrers)];
    }
}
