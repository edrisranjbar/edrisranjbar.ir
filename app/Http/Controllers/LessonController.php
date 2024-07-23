<?php

namespace App\Http\Controllers;

use App\Models\CourseSection;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Tutorial;
use FFMpeg;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::all();
        return view('admin.tutorials.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $tutorials = Tutorial::all();
        $sections = CourseSection::all();
        return view('admin.tutorials.lessons.createOrEdit', compact('tutorials', 'sections'));
    }

    public function edit(int $id)
    {
        $lesson = Lesson::findOrFail($id);
        $tutorials = Tutorial::all();
        $sections = CourseSection::all();
        return view('admin.tutorials.lessons.createOrEdit', compact('lesson', 'tutorials', 'sections'));
    }

    public function store(Request $request)
    {
        $validationRules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:50',
            'order_id' => 'nullable|integer|min:1|max:1000',
            'status' => 'required|in:public,private,draft',
            'isFree' => 'nullable|in:true,false',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'file' => 'nullable|file|mimes:zip',
            'video' => 'required|file|mimetypes:video/*',
            'tutorial_id' => 'required|exists:tutorials,id',
            'section_id' => 'required|exists:sections,id',
        ];
        $validatedData = $request->validate($validationRules);

        // Handle file uploads
        if ($request->hasFile('thumbnail')) {
            $request->file('thumbnail')->store('public/upload');
            $validatedData['thumbnail'] = $request->file('thumbnail')->hashName();
        }
        
        // Handle file uploads
        if ($request->hasFile('file')) {
            $request->file('file')->store('public/upload');
            $validatedData['file_path'] = $request->file('file')->hashName();
        }
        
        // Handle video uploads
        if ($request->hasFile('video')) {
            $video = $request->file('video');

            // Store the video file
            $video->store('public/upload');
            $videoFullPath = $request->file('video')->hashName();

            // Use FFmpeg to get the duration of the video
            $ffmpeg = FFMpeg\FFMpeg::create();
            $video = $ffmpeg->open('storage/upload/' . $videoFullPath);
            $duration = $video->getStreams()->first()->get('duration');

            // Add the duration in seconds to the validated data
            $validatedData['video_path'] = $videoFullPath;
            $validatedData['duration'] = intval($duration);
        }

        $validatedData['isFree'] = boolval($validatedData['isFree'] ?? false);
        unset($validatedData['file'],$validatedData['video']);
        Lesson::create($validatedData);
        return redirect()->route('lessons.index')->with('success', 'درس با موفقیت اضافه شد.');
    }

    public function update(Request $request, int $id)
    {
        $lesson = Lesson::findOrFail($id);
        $validationRules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:50',
            'order_id' => 'nullable|integer|min:1|max:1000',
            'status' => 'required|in:public,private,draft',
            'isFree' => 'nullable|in:true,false',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'file' => 'nullable|file|mimes:zip',
            'video' => 'nullable|file|mimetypes:video/*',
            'tutorial_id' => 'required|exists:tutorials,id',
            'section_id' => 'required|exists:sections,id',
        ];
        $validatedData = $request->validate($validationRules);

        // Handle file uploads
        if ($request->hasFile('thumbnail')) {
            $request->file('thumbnail')->store('public/upload');
            $validatedData['thumbnail'] = $request->file('thumbnail')->hashName();
            Storage::delete('storage/upload/' . $lesson->thumbnail);
        }
        
        // Handle file uploads
        if ($request->hasFile('file')) {
            $request->file('file')->store('public/upload');
            $validatedData['file_path'] = $request->file('file')->hashName();
            Storage::delete('storage/upload/' . $lesson->file_path);
        }

        // Handle video uploads
        if ($request->hasFile('video')) {
            $video = $request->file('video');

            // Store the video file
            $video->store('public/upload');

            // Get the full path to the stored video file
            $videoFullPath = $request->file('video')->hashName();

            // Use FFmpeg to get the duration of the video
            $ffmpeg = FFMpeg\FFMpeg::create();
            $video = $ffmpeg->open('storage/upload/' . $videoFullPath);
            $duration = $video->getStreams()->first()->get('duration');

            // Add the duration in seconds to the validated data
            $validatedData['video_path'] = $videoFullPath;
            $validatedData['duration'] = intval($duration);

            Storage::delete('storage/upload/' . $lesson->video_path);
        }

        $validatedData['isFree'] = boolval($validatedData['isFree'] ?? false);
        unset($validatedData['file'], $validatedData['video']);
        $lesson->update($validatedData);
        return redirect()->route('lessons.index')->with('success', 'درس با موفقیت ویرایش شد.');
    }

    public function destroy(int $id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
        return redirect()->route('lessons.index')->with('success', 'درس مورد نظر با موفقیت حذف شد.');
    }
}
