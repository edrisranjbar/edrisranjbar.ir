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

class HomeController extends Controller
{
    public function index()
    {
        $widgets = $this->getAllWidgets();
        $coursesUrl = url(Tutorial::tutorialsLink);
        $blogUrl = url(Post::blogLink);
        $tutorials = Tutorial::all();
        $posts = Post::all();
        $user = Auth::guard('user')?->user();
        return view('index', compact('widgets', 'coursesUrl', 'blogUrl', 'tutorials', 'posts', 'user'));
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

        return view('blog.index', compact('posts', 'searchQuery'));
    }

    public function blogPost($slug)
    {
        $post = Post::where('slug', $slug)->first();
        if (!$post) {
            abort(404);
        }
        return view('blog.show', compact('post'));
    }

    public function podcasts()
    {
        return view('podcasts.index');
    }

    public function tutorials()
    {
        $tutorials = Tutorial::all();
        return view('tutorials.index', compact('tutorials'));
    }

    public function tutorial(string $slug)
    {
        $tutorial = Tutorial::where('slug', $slug)->first();
        $lessons = Lesson::where('tutorial_id', $tutorial->id)->first();
        if (!$tutorial) {
            abort(404);
        }
        $user = Auth::guard('user')?->user();
        $userHasEnrolled = $user && $user->tutorials->contains($tutorial->id);
        return view('tutorials.show', compact('tutorial', 'lessons', 'userHasEnrolled'));
    }

    public function lesson(string $tutorialSlug, string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $totalLessonsCount = $lesson->section->tutorial->lessonsCount();
        $currentLessonOrder = $lesson->getOrder();
        $progress = AppHelper::calculateProgress(currentLessonOrder: $currentLessonOrder, totalNumberOfLessons: $totalLessonsCount);
        $prevLessonURL = $lesson->previousLesson()?->id ? "tutorials/" . $lesson->section->tutorial->slug . "/lessons/" . $lesson->previousLesson()?->id : '#';
        $nextLessonURL =
        $lesson->nextLesson()?->id ? "tutorials/" . $lesson->section->tutorial->slug . "/lessons/" . $lesson->nextLesson()?->id : '#';

        $user = Auth::guard('user')?->user();
        UserTutorialProgress::updateOrCreate(
            ['user_id' => $user->id, 'tutorial_id' => $lesson->section->tutorial->id],
            ['progress' => $progress]
        );

        return view('tutorials.lessons.show', compact('lesson', 'prevLessonURL', 'nextLessonURL', 'progress'));
    }

}
