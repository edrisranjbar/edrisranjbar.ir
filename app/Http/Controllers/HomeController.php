<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class HomeController extends Controller
{
    private array $tags = [];

    public function __construct()
    {
        $this->tags = ['ادریس رنجبر', 'آموزش برنامه نویسی', 'آموزش طراحی وب سایت', 'طراحی سایت', 'وب سایت ادریس رنجبر'];
    }

    public function index()
    {
        $widgets = $this->getAllWidgets();
        $blogUrl = url(Post::blogLink);
        $posts = Post::where(['status' => 'published'])
            ->orderBy('updated_at', 'desc')->get();
        $user = Auth::guard('user')?->user();
        
        $SEOData = new SEOData(
            tags: $this->tags,
            image: $widgets['hero']['image']['src'],
        );
        return view('index', compact('widgets', 'blogUrl', 'posts', 'user', 'SEOData'));
    }

    public function getAllWidgets()
    {
        return [
            'hero' => [
                'subtitle' => 'ســــلــااام، مــن',
                'title' => 'ادریس رنجبــر&nbsp;<span>هستــم</span>',
                'description' => 'توسعه دهنده بک اند وب، مدرس و طبیعت گرد. علاقه&nbsp;مند به اشتراک تجربیات ومهارت ها.',
                'image' => ['src' => URL::to('/') . '/images/profile.png', 'alt' => 'ادریس رنجبر'],
            ],
        ];
    }

    public function blog(Request $request)
    {
        $searchQuery = $request->input('search');
        if ($searchQuery) {
            $posts = Post::where(['status' => 'published']);
            $posts = $posts->where('title', 'like', '%' . $searchQuery . '%')
                ->orWhere('content', 'like', '%' . $searchQuery . '%')
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $posts = Post::where(['status' => 'published'])
                ->orderBy('updated_at', 'desc')->get();
        }
        $pinnedPosts = Post::where(['status' => 'published'])
            ->wherePinned(true)
            ->orderBy('updated_at', 'desc')
            ->take(2)->get();
        $SEOData = new SEOData(
            title: 'وبلاگ',
            tags: $this->tags,
        );
        return view('blog.index', compact('posts', 'searchQuery', 'pinnedPosts', 'SEOData'));
    }

    public function blogPost($slug)
    {
        $post = Post::where(['slug' => $slug, 'status' => 'published'])->first();
        if (!$post) {
            abort(404);
        }
        $comments = $post->confirmedComments;
        $SEOData = $post->getDynamicSEOData();
        return view('blog.show', compact('post', 'comments', 'SEOData'));
    }

    public function donate()
    {
        $productPrice = 21_200_000;
        $paidAmount = 0;
        $progress = intval($paidAmount / $productPrice * 100);
        $SEOData = new SEOData(
            title: '💗 حمایت مالی',
            description: 'ساختن آموزش خوب و باکیفیت زمان‌بر و هزینه برداره. اگر دوست دارین توی این کار مشارکت داشته باشین و به تولید محتوای باکیفیت آموزشی درحوزه برنامه نویسی به زبان فارسی کمک کنین میتونین به نوبه خودتون سهمی در این پروسه داشته باشین و البته یه دلخوشی کوچیک و فانی هم برا منه😍',
            tags: array_merge($this->tags, ['حمایت از آموزش های فارسی', 'کمک به محتوای فارسی']),
        );
        return view('donate', compact('productPrice', 'progress', 'SEOData'));
    }
}
