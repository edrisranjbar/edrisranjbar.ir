<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AdminLoginMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Resend\Laravel\Facades\Resend;

class AdminAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Handle admin login.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'نام کاربری یا رمز عبور اشتباه است'
            ], 401);
        }

        if (!$admin->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'حساب کاربری شما غیرفعال شده است'
            ], 403);
        }

        // Revoke previous tokens
        $admin->tokens()->delete();
        
        // Create new token
        $token = $admin->createToken('admin-panel-token')->plainTextToken;
        
        // Send login notification email
        try {
            Log::info('Attempting to send login email to: ' . $admin->email);
            
            $fromEmail = config('mail.from.address', 'no-reply@mail.edrisranjbar.ir');
            $fromName = config('mail.from.name', 'ادریس رنجبر');
            $loginTime = now()->format('Y-m-d H:i:s');
            
            // Using Resend directly
            Resend::emails()->send([
                'from' => "{$fromName} <{$fromEmail}>",
                'to' => [$admin->email],
                'subject' => 'گزارش ورود به پنل مدیریت ادیکدز',
                'html' => view('emails.admin-login', [
                    'admin' => $admin,
                    'loginTime' => $loginTime
                ])->render(),
                'tags' => [
                    'type' => 'admin_login',
                    'admin_id' => $admin->id
                ]
            ]);
            
            Log::info('Login email sent successfully via Resend');
        } catch (\Exception $e) {
            // Log the error but continue with login process
            Log::error('Failed to send admin login email: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
        
        return response()->json([
            'success' => true,
            'message' => 'ورود با موفقیت انجام شد',
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
            ],
            'token' => $token
        ]);
    }

    /**
     * Handle admin logout.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'خروج با موفقیت انجام شد'
        ]);
    }

    /**
     * Get admin profile.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $admin = $request->user();
        
        return response()->json([
            'success' => true,
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'created_at' => $admin->created_at,
            ]
        ]);
    }

    /**
     * Update admin profile.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $request->user()->id,
        ], [
            'name.required' => 'نام نمی‌تواند خالی باشد',
            'name.max' => 'نام نمی‌تواند بیشتر از 255 کاراکتر باشد',
            'email.required' => 'ایمیل نمی‌تواند خالی باشد',
            'email.email' => 'فرمت ایمیل وارد شده صحیح نیست',
            'email.max' => 'ایمیل نمی‌تواند بیشتر از 255 کاراکتر باشد',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $admin = $request->user();
            
            // Check if any changes were made
            if ($admin->name === $request->name && $admin->email === $request->email) {
                return response()->json([
                    'success' => true,
                    'message' => 'هیچ تغییری اعمال نشد',
                    'admin' => [
                        'id' => $admin->id,
                        'name' => $admin->name,
                        'email' => $admin->email,
                        'created_at' => $admin->created_at,
                    ]
                ]);
            }
            
            // Update profile
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->save();

            return response()->json([
                'success' => true,
                'message' => 'پروفایل با موفقیت به‌روزرسانی شد',
                'admin' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'created_at' => $admin->created_at,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطایی در به‌روزرسانی پروفایل رخ داد',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change admin password.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'رمز عبور فعلی الزامی است',
            'new_password.required' => 'رمز عبور جدید الزامی است',
            'new_password.min' => 'رمز عبور جدید باید حداقل 8 کاراکتر باشد',
            'new_password.confirmed' => 'تکرار رمز عبور جدید مطابقت ندارد',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $admin = $request->user();

            // Check current password
            if (!Hash::check($request->current_password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'رمز عبور فعلی اشتباه است'
                ], 400);
            }

            // Check if new password is same as current password
            if (Hash::check($request->new_password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'رمز عبور جدید نمی‌تواند مشابه رمز عبور فعلی باشد'
                ], 400);
            }

            // Update password
            $admin->password = Hash::make($request->new_password);
            $admin->save();

            return response()->json([
                'success' => true,
                'message' => 'رمز عبور با موفقیت تغییر یافت'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطایی در تغییر رمز عبور رخ داد',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
