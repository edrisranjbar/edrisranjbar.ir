<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get counts
        $postsCount = Post::count();
        $categoriesCount = Category::count();
        $pendingCommentsCount = Comment::pending()->count();
        $publishedPostsCount = Post::published()->count();

        // Return statistics
        return response()->json([
            'stats' => [
                'posts' => $postsCount,
                'categories' => $categoriesCount,
                'pendingComments' => $pendingCommentsCount,
                'publishedCount' => $publishedPostsCount,
                'views' => 0, // Placeholder for future views tracking
            ]
        ]);
    }
} 