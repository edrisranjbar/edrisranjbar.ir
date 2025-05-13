<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommentReplyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The reply comment instance.
     *
     * @var Comment
     */
    public $reply;

    /**
     * The parent comment instance.
     *
     * @var Comment
     */
    public $parentComment;

    /**
     * The post instance.
     *
     * @var Post
     */
    public $post;

    /**
     * Create a new message instance.
     */
    public function __construct(Comment $reply, Comment $parentComment, Post $post)
    {
        $this->reply = $reply;
        $this->parentComment = $parentComment;
        $this->post = $post;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'پاسخ جدید به دیدگاه شما در ادیکدز',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.comment-reply',
            with: [
                'reply' => $this->reply,
                'parentComment' => $this->parentComment,
                'post' => $this->post,
                'postUrl' => url('/blog/' . $this->post->slug),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
