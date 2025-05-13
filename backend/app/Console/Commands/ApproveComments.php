<?php

namespace App\Console\Commands;

use App\Mail\CommentApprovedMail;
use App\Models\Comment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ApproveComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comments:approve {id?} {--all : Approve all pending comments}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approve pending comment(s)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $approveAll = $this->option('all');

        if (!$id && !$approveAll) {
            $this->listPendingComments();
            return;
        }

        if ($approveAll) {
            return $this->approveAllComments();
        }

        return $this->approveComment($id);
    }

    /**
     * List all pending comments
     */
    private function listPendingComments()
    {
        $pendingComments = Comment::where('status', 'pending')->with('post')->get();

        if ($pendingComments->isEmpty()) {
            $this->info('No pending comments to approve.');
            return;
        }

        $this->info('Pending comments:');
        $headers = ['ID', 'Name', 'Post', 'Content', 'Created At'];
        $rows = [];

        foreach ($pendingComments as $comment) {
            $rows[] = [
                $comment->id,
                $comment->name,
                $comment->post ? $comment->post->title : 'Post deleted',
                mb_substr($comment->content, 0, 40) . (mb_strlen($comment->content) > 40 ? '...' : ''),
                $comment->created_at
            ];
        }

        $this->table($headers, $rows);
        $this->info('To approve a comment, run: php artisan comments:approve {id}');
        $this->info('To approve all comments, run: php artisan comments:approve --all');
    }

    /**
     * Approve a specific comment
     */
    private function approveComment($id)
    {
        $comment = Comment::with('post')->find($id);

        if (!$comment) {
            $this->error("Comment with ID {$id} not found.");
            return 1;
        }

        if ($comment->status === 'approved') {
            $this->info("Comment {$id} is already approved.");
            return 0;
        }

        $comment->status = 'approved';
        $comment->save();

        // Send email notification to the commenter
        try {
            if ($comment->email && $comment->post) {
                Mail::to($comment->email)->send(new CommentApprovedMail($comment, $comment->post));
                $this->info("Notification email sent to {$comment->email}");
            }
        } catch (\Exception $e) {
            $this->warn("Could not send email notification: {$e->getMessage()}");
        }

        $this->info("Comment {$id} has been approved successfully.");
        return 0;
    }

    /**
     * Approve all pending comments
     */
    private function approveAllComments()
    {
        $pendingComments = Comment::where('status', 'pending')->with('post')->get();
        
        if ($pendingComments->isEmpty()) {
            $this->info('No pending comments to approve.');
            return 0;
        }
        
        $count = $pendingComments->count();
        
        $this->output->progressStart($count);
        
        foreach ($pendingComments as $comment) {
            $comment->status = 'approved';
            $comment->save();
            
            // Send email notification
            try {
                if ($comment->email && $comment->post) {
                    Mail::to($comment->email)->send(new CommentApprovedMail($comment, $comment->post));
                }
            } catch (\Exception $e) {
                $this->warn("Could not send email to {$comment->email}: {$e->getMessage()}");
            }
            
            $this->output->progressAdvance();
        }
        
        $this->output->progressFinish();
        
        $this->info("{$count} comments have been approved successfully.");
        return 0;
    }
}
