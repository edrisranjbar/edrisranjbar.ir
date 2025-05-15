<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminLoginMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The admin instance.
     *
     * @var Admin
     */
    public $admin;

    /**
     * The login time.
     *
     * @var string
     */
    public $loginTime;

    /**
     * Create a new message instance.
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->loginTime = now()->format('Y-m-d H:i:s');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'گزارش ورود به پنل مدیریت ادیکدز',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-login',
            with: [
                'admin' => $this->admin,
                'loginTime' => $this->loginTime,
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