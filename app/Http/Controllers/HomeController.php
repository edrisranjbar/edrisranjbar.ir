<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function index()
    {
        $widgets = $this->getAllWidgets();
        $coursesUrl = '#';
        $blogUrl = '#';
        $tutorials = Tutorial::all();
        $posts = Post::all();
        return view('index', compact('widgets', 'coursesUrl', 'blogUrl', 'tutorials', 'posts'));
    }

    public function getAllWidgets()
    {
        return [
            'hero' => [
                'subtitle' => 'ســــلــااام، مــن',
                'title' => 'ادریس رنجبــر&nbsp;<span>هستــم</span>',
                'description' => 'توسعه دهنده بک اند وب، مدرس و طبیعت گرد. علاقه&nbsp;مند به اشتراک تجربیات ومهارت ها.',
                'image' => ['src' => URL::to('/') . '/images/profile.png', 'alt' => 'ادریس رنجبر'],
                'students' => [
                    ['src' => URL::to('/') . '/images/student1.jpg'],
                    ['src' => URL::to('/') . '/images/student2.jpg'],
                    ['src' => URL::to('/') . '/images/student3.jpg'],
                    ['src' => URL::to('/') . '/images/student4.jpg'],
                    ['src' => URL::to('/') . '/images/student5.jpg'],
                ]
            ],
        ];
    }

    public function blog(Request $request)
    {
        $searchQuery = $request->input('search');
        // If a search query is provided, perform the search
        if ($searchQuery) {
            $posts = Post::where('title', 'like', '%' . $searchQuery . '%')
                ->orWhere('content', 'like', '%' . $searchQuery . '%')
                ->get();
        } else {
            // If no search query is provided, get the latest posts
            $posts = Post::latest()->get();
        }

        return view('blog.index', compact('posts'));
    }
}
