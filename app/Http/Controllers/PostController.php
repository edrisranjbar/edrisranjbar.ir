<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'categories' => 'nullable|array',
            'tags' => 'nullable|string',
            'slug' => 'required|string|max:50'
        ]);

        $post = new Post();
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->status = $validatedData['status'];
        $post->slug = $validatedData['slug'];
        $post->author = Auth::guard('admin')->user()->id;
        // Upload and save the thumbnail if provided
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailPath = $thumbnail->store('thumbnails', 'public');
            $post->thumbnail = $thumbnailPath;
        }

        // Save the post
        $post->save();

        // Save the categories
        $categories = $validatedData['categories'] ?? [];
        $post->categories()->attach($categories);

        // Save the tags if provided
        if (!empty($validatedData['tags'])) {
            $tagNames = explode(',', $validatedData['tags']);
            $tagNames = array_map('trim', $tagNames);

            $tags = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tags[] = $tag->id;
            }

            $post->tags()->sync($tags);
        }
        return redirect()->route('posts.index')->with('success', 'نوشته با موفقیت ایجاد شد.');
    }


    public function show(int $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(int $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $post = Post::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'categories' => 'nullable|array',
            'tags' => 'nullable|string',
            'slug' => 'required|string|max:50'
        ]);

        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->status = $validatedData['status'];
        $post->slug = $validatedData['slug'];

        // Update the thumbnail if provided
        if ($request->hasFile('thumbnail')) {
            $request->thumbnail->store('public/upload');
            $post->thumbnail = $request->thumbnail->hashName();
        }

        // Update the post
        $post->save();

        // Update the categories
        $categories = $validatedData['categories'] ?? [];
        $post->categories()->sync($categories);

        // Update the tags if provided
        if (!empty($validatedData['tags'])) {
            $tagNames = explode(',', $validatedData['tags']);
            $tagNames = array_map('trim', $tagNames);

            $tags = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tags[] = $tag->id;
            }

            $post->tags()->sync($tags);
        }

        return redirect()->route('posts.index')->with('success', 'نوشته با موفقیت بروزرسانی شد.');
    }


    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
