<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Resend\Laravel\Facades\Resend;

class TestResendController extends Controller
{
    /**
     * Test Resend API integration
     *
     * @return \Illuminate\Http\Response
     */
    public function testEmail()
    {
        try {
            $recipientEmail = config('mail.to.address', 'edrisranjbar.dev@gmail.com');
            $fromEmail = config('mail.from.address', 'no-reply@mail.edrisranjbar.ir');
            $fromName = config('mail.from.name', 'ادریس رنجبر');
            $domain = config('resend.domain', 'mail.edrisranjbar.ir');
            
            // Render the email template
            $html = view('emails.test')->render();
            
            // Send email using Resend
            $response = Resend::emails()->send([
                'from' => "{$fromName} <{$fromEmail}>",
                'to' => [$recipientEmail],
                'subject' => 'تست Resend API',
                'html' => $html,
                'tags' => [
                    'type' => 'test_email',
                    'source' => 'api_test'
                ]
            ]);
            
            Log::info('Resend test email sent', [
                'resend_id' => $response->id,
                'recipient' => $recipientEmail,
                'domain' => $domain
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'ایمیل تست با موفقیت ارسال شد',
                'resend_id' => $response->id,
                'from_domain' => $domain
            ]);
            
        } catch (\Exception $e) {
            Log::error('Resend test email failed', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'خطا در ارسال ایمیل تست: ' . $e->getMessage()
            ], 500);
        }
    }
} 