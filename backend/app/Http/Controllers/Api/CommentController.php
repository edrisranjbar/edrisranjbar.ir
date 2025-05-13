<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Mail\CommentApprovedMail;
use App\Mail\CommentReplyMail;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');
        
        $comments = Comment::with('post')
            ->when($status === 'pending', function ($query) {
                return $query->pending();
            })
            ->when($status === 'approved', function ($query) {
                return $query->approved();
            })
            ->when($status === 'trashed', function ($query) {
                return $query->trashed();
            })
            ->latest()
            ->paginate(15);
        
        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create the comment
        $comment = Comment::create([
            'post_id' => $request->post_id,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'status' => 'pending', // All comments start as pending
            'is_admin_reply' => false, // Public comments are not admin replies
        ]);

        // Get post information for the response
        $post = Post::find($request->post_id);

        return response()->json([
            'success' => true,
            'message' => 'دیدگاه شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد.',
            'comment' => new CommentResource($comment),
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
            ]
        ]);
    }

    /**
     * Display comments for a specific post.
     */
    public function postComments(string $postId)
    {
        $post = Post::findOrFail($postId);
        
        $comments = $post->approvedComments()->latest()->get();
        
        return CommentResource::collection($comments);
    }

    /**
     * Update the status of a comment.
     */
    public function updateStatus(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,trashed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = Comment::findOrFail($id);
        $oldStatus = $comment->status;
        $comment->status = $request->status;
        $comment->save();

        // Send notification email if the comment was approved
        if ($oldStatus !== 'approved' && $request->status === 'approved') {
            $this->sendCommentApprovedNotification($comment);
        }

        return response()->json([
            'success' => true,
            'message' => 'وضعیت دیدگاه با موفقیت بروزرسانی شد',
            'comment' => new CommentResource($comment),
        ]);
    }

    /**
     * Submit an admin reply to a comment.
     */
    public function adminReply(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        $parentComment = Comment::findOrFail($id);
        
        // Create the admin reply
        $reply = Comment::create([
            'post_id' => $parentComment->post_id,
            'parent_id' => $parentComment->id,
            'name' => 'ادمین',
            'email' => config('mail.from.address'),
            'content' => $request->content,
            'status' => 'approved', // Admin replies are automatically approved
            'is_admin_reply' => true,
        ]);

        // Send notification email to the original commenter
        $this->sendReplyNotification($reply, $parentComment);

        return response()->json([
            'success' => true,
            'message' => 'پاسخ با موفقیت ارسال شد',
            'reply' => new CommentResource($reply),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::with(['post', 'replies'])->findOrFail($id);
        
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = Comment::findOrFail($id);
        $comment->content = $request->content;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'دیدگاه با موفقیت بروزرسانی شد',
            'comment' => new CommentResource($comment),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'دیدگاه با موفقیت حذف شد'
        ]);
    }

    /**
     * Send email notification when a comment is approved.
     */
    private function sendCommentApprovedNotification(Comment $comment)
    {
        // Skip if the comment has already been notified
        if ($comment->notified) {
            return;
        }

        try {
            $post = $comment->post;
            
            // Send the notification email
            Mail::to($comment->email)->send(new CommentApprovedMail($comment, $post));
            
            // Mark as notified
            $comment->notified = true;
            $comment->save();
        } catch (\Exception $e) {
            // Log error but don't break the flow
            Log::error('Failed to send comment approval notification: ' . $e->getMessage());
        }
    }

    /**
     * Send email notification when an admin replies to a comment.
     */
    private function sendReplyNotification(Comment $reply, Comment $parentComment)
    {
        try {
            $post = $reply->post;
            
            // Send the notification email
            Mail::to($parentComment->email)->send(new CommentReplyMail($reply, $parentComment, $post));
            
            // Mark as notified
            $reply->notified = true;
            $reply->save();
        } catch (\Exception $e) {
            // Log error but don't break the flow
            Log::error('Failed to send reply notification: ' . $e->getMessage());
        }
    }
}
