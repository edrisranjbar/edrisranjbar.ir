<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.index');
    }

    public function show()
    {
        $user = Auth::guard('user')->user();
        return view('user.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('user')->user();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);

        $user->name = $validatedData['name'];

        // Update password if provided
        if ($request->password) {
            $user->password = Hash::make($validatedData['password']);
        }

        if ($request->hasFile('profile_photo')) {
            $request->profile_photo->store('public/upload');
            $user->profile_photo = $request->profile_photo->hashName();
        }


        $user->save();
        return redirect()->route('user.profile')->with('success', 'پروفایل کاربری شما با موفقیت به روزرسانی شد');
    }
}
