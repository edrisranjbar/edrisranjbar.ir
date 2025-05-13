<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        $admin = $request->user();

        // Check current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'رمز عبور فعلی اشتباه است'
            ], 400);
        }

        // Update password
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'رمز عبور با موفقیت تغییر یافت'
        ]);
    }
}
