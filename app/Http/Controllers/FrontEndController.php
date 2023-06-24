<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                'image' => ['src' => 'http://localhost:8000/images/profile.png', 'alt' => 'ادریس رنجبر'],
                'students' => [
                    ['src' => 'http://localhost:8000/images/student1.jpg'],
                    ['src' => 'http://localhost:8000/images/student2.jpg'],
                    ['src' => 'http://localhost:8000/images/student3.jpg'],
                    ['src' => 'http://localhost:8000/images/student4.jpg'],
                    ['src' => 'http://localhost:8000/images/student5.jpg'],
                ]
            ],
        ];
    }
}
