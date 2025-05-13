<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Resend\Laravel\Facades\Resend;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('Contact form request received', [
            'request_data' => $request->all(),
            'headers' => $request->headers->all(),
            'ip' => $request->ip()
        ]);
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            Log::warning('Contact form validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'لطفاً تمام فیلدها را به درستی پر کنید',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get validated data
            $data = $validator->validated();
            
            // Add timestamp if not provided
            if (!isset($data['timestamp'])) {
                $data['timestamp'] = now()->toISOString();
            }
            
            // Log the contact request
            Log::info('Contact form validation passed, proceeding to save', $data);
            
            try {
                // Save to database
                $contact = Contact::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'subject' => $data['subject'],
                    'message' => $data['message'],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
                
                Log::info('Contact form entry saved successfully', ['contact_id' => $contact->id]);
            } catch (\Exception $dbException) {
                Log::error('Database error while saving contact form', [
                    'exception' => $dbException->getMessage(),
                    'trace' => $dbException->getTraceAsString()
                ]);
                throw $dbException;
            }
            
            try {
                // Send email notification using Resend
                $this->sendEmailViaResend($data);
                Log::info('Email notification sent successfully via Resend');
            } catch (\Exception $emailException) {
                Log::warning('Failed to send email notification, but contact was saved', [
                    'exception' => $emailException->getMessage()
                ]);
                // Don't re-throw this exception since we still succeeded in saving the contact
            }
            
            return response()->json([
                'success' => true,
                'message' => 'پیام با موفقیت ارسال شد'
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Contact form processing error', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'class' => get_class($e)
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'خطایی در پردازش درخواست رخ داد'
            ], 500);
        }
    }
    
    /**
     * Send email notification using Resend API
     *
     * @param  array  $data
     * @return void
     */
    private function sendEmailViaResend(array $data)
    {
        $recipientEmail = config('mail.to.address', 'edrisranjbar.dev@gmail.com');
        $fromEmail = config('mail.from.address', 'no-reply@mail.edrisranjbar.ir');
        $fromName = config('mail.from.name', 'ادریس رنجبر');
        $domain = config('resend.domain', 'mail.edrisranjbar.ir');
        
        // Using Resend directly
        Resend::emails()->send([
            'from' => "{$fromName} <{$fromEmail}>",
            'to' => [$recipientEmail],
            'subject' => 'پیام جدید از وبسایت: ' . $data['subject'],
            'html' => view('emails.contact', ['data' => $data])->render(),
            'tags' => [
                'type' => 'contact_form',
                'source' => 'website'
            ]
        ]);
    }
    
    /**
     * Legacy method for email sending via Laravel Mail
     * 
     * @param  array  $data
     * @return void
     */
    private function sendEmailNotification(array $data)
    {
        $recipientEmail = config('mail.to.address', 'edrisranjbar.dev@gmail.com');
        
        Mail::send('emails.contact', ['data' => $data], function ($message) use ($data, $recipientEmail) {
            $message->to($recipientEmail)
                ->subject('پیام جدید از وبسایت: ' . $data['subject']);
        });
    }
} 