<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'nullable|exists:comments',
            'post_id' => 'nullable|exists:posts,id,status,published',
            'message' => 'required|max:255'
        ]);
        if (!Auth::guard('user')?->user()?->id) {
            return redirect('user/login');
        }
        $validatedData['author_id'] = Auth::guard('user')?->user()?->id;
        $validatedData['parent_id'] = null;
        if ($request->filled('id')) {
            $comment = Comment::findOrFail($validatedData['id']);
            $validatedData['parent_id'] = $comment->id;
        }
        $comment = new Comment([
            'post_id' => $validatedData['post_id'],
            'parent_id' => $validatedData['parent_id'],
            'author_id' => $validatedData['author_id'],
            'message' => $validatedData['message'],
        ]);
        $comment->save();
        return redirect()->back()->with('success', 'دیدگاه شما با موفقیت ثبت شد.');
    }
}
