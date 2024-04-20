<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Post;
use App\Models\Tutorial;
use App\Models\Lesson;
use App\Models\UserTutorialProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
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
        $coursesUrl = url(Tutorial::tutorialsLink);
        $blogUrl = url(Post::blogLink);
        $tutorials = Tutorial::where(['status' => 'published'])
            ->orderBy('updated_at', 'desc')->get();
        $posts = Post::where(['status' => 'published'])
            ->orderBy('updated_at', 'desc')->get();
        $user = Auth::guard('user')?->user();
        $SEOData = new SEOData(
            tags: $this->tags,
            image: $widgets['hero']['image']['src'],
        );
        return view('index', compact('widgets', 'coursesUrl', 'blogUrl', 'tutorials', 'posts', 'user', 'SEOData'));
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

    public function podcasts()
    {
        $episodes = [];
        $xml = simplexml_load_string(file_get_contents('rss.xml'));
        foreach ($xml->channel->item as $item) {
            $title = (string) $item->title;
            $description = (string) $item->description;
            $pubDate = (string) $item->pubDate;
            $link = (string) $item->link;
            $file = (string) $item->enclosure['url'];
            $type = (string) $item->enclosure['type'];
            $episodes[] = [
                'title' => $title,
                'description' => $description,
                'pubDate' => $pubDate,
                'link' => $link,
                'file' => $file,
                'type' => $type,
            ];
        }
        $SEOData = new SEOData(
            title: 'جت کدکست (پادکست جت کد)',
            tags: $this->tags,
        );
        return view('podcasts.index', compact('episodes', 'SEOData'));
    }

    public function tutorials()
    {
        $tutorials = Tutorial::where(['status' => 'published'])->get();
        $SEOData = new SEOData(
            title: 'دوره های آموزشی',
            tags: array_merge($this->tags, ['دوره آموزشی طراحی سایت', 'آموزش برنامه نویسی']),
        );
        return view('tutorials.index', compact('tutorials', 'SEOData'));
    }

    public function tutorial(string $slug)
    {
        $condition = ['slug' => $slug, 'status' => 'published'];
        if (Auth::guard('admin')->check()) {
            $condition = ['slug' => $slug];
        }
        $tutorial = Tutorial::where($condition)?->first();
        if (!$tutorial) {
            abort(404);
        }
        $lessons = Lesson::where('tutorial_id', $tutorial->id)->first();
        $user = Auth::guard('user')?->user();
        $userHasEnrolled = $user && $user->tutorials->contains($tutorial->id);
        $SEOData = $tutorial->getDynamicSEOData();
        return view('tutorials.show', compact('tutorial', 'lessons', 'userHasEnrolled', 'SEOData'));
    }

    public function lesson(string $tutorialSlug, string $id)
    {
        $lesson = Lesson::findOrFail($id);
        if (!Auth::guard('user')->check() && !Auth::guard('admin')->check()) {
            return redirect()->route('user.login');
        }
        $totalLessonsCount = $lesson->section->tutorial->lessonsCount();
        $currentLessonOrder = $lesson->getOrder();
        $progress = AppHelper::calculateProgress(currentLessonOrder: $currentLessonOrder, totalNumberOfLessons: $totalLessonsCount);
        $prevLessonURL = $lesson->previousLesson()?->id ? "tutorials/" . $lesson->section->tutorial->slug . "/lessons/" . $lesson->previousLesson()?->id : '#';
        $nextLessonURL =
            $lesson->nextLesson()?->id ? "tutorials/" . $lesson->section->tutorial->slug . "/lessons/" . $lesson->nextLesson()?->id : '#';
        if (Auth::guard('user')->check()) {
            $user = Auth::guard('user')?->user();
            UserTutorialProgress::updateOrCreate(
                ['user_id' => $user->id, 'tutorial_id' => $lesson->section->tutorial->id],
                ['progress' => $progress]
            );
        }
        $SEOData = $lesson->getDynamicSEOData();
        return view('tutorials.lessons.show', compact('lesson', 'prevLessonURL', 'nextLessonURL', 'progress', 'SEOData'));
    }

    public function donate()
    {
        $productPrice = 21_200_000;
        $paidAmount = 0;
        $progress = intval($paidAmount / $productPrice * 100);
        $SEOData = new SEOData(
            title: 'حمایت مالی',
            tags: array_merge($this->tags, ['حمایت از آموزش های فارسی', 'کمک به محتوای فارسی']),
        );
        return view('donate', compact('productPrice', 'progress', 'SEOData'));
    }
}
