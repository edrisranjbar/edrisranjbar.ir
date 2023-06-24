<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class FrontEndController extends Controller
{
    public function index()
    {
        $widgets = $this->getAllWidgets();
        $coursesUrl = '#';
        $blogUrl = '#';
        return view('index', compact('widgets', 'coursesUrl', 'blogUrl'));
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
}
