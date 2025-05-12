<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
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
            Log::info('New contact form submission', $data);
            
            // Save to database
            $contact = Contact::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            // Send email notification
            $this->sendEmailNotification($data);
            
            return response()->json([
                'success' => true,
                'message' => 'پیام با موفقیت ارسال شد'
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'خطایی در پردازش درخواست رخ داد'
            ], 500);
        }
    }
    
    /**
     * Send email notification about the contact form submission
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