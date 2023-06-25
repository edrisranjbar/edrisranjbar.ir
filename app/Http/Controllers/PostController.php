<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Category;

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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'nullable|array',
            'tags' => 'nullable|string',
            'slug' => 'required|string|max:50'
        ]);

        $post = new Post();
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->status = $validatedData['status'];

        // Upload and save the thumbnail if provided
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailPath = $thumbnail->store('thumbnails', 'public');
            $post->thumbnail = $thumbnailPath;
        }

        // Save the post
        $post->save();

        // Save the categories
        $categories = $validatedData['categories'];
        $post->categories()->attach($categories);

        // Save the tags if provided
        if (!empty($validatedData['tags'])) {
            $tags = explode(',', $validatedData['tags']);
            $tags = array_map('trim', $tags);
            $post->tags()->sync($tags);
        }

        return redirect()->route('posts.index')->with('success', 'نوشته با موفقیت ایجاد شد.');
    }


    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'slug' => 'required|unique:posts,slug,' . $post->id,
            'title' => 'required',
            'content' => 'required',
            'status' => 'in:public,private,draft',
            'thumbnail' => 'nullable',
            'author' => 'required|exists:admins,id',
        ]);

        $post->update($validatedData);

        return redirect()->route('admin.posts.show', $post->id)
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
