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
            'slug' => 'required|unique:posts',
            'title' => 'required',
            'content' => 'required',
            'status' => 'in:public,private,draft',
            'thumbnail' => 'nullable',
            'author' => 'required|exists:admins,id',
        ]);

        $post = Post::create($validatedData);

        return redirect()->route('admin.posts.show', $post->id)
            ->with('success', 'Post created successfully.');
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
