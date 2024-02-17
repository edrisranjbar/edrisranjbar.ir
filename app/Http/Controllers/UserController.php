<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function dashboard()
    {
        $user = Auth::guard('user')->user();
        $suggestedTutorial = Tutorial::first();
        $averageTotalProgress = $user->getAverageTotalProgress();
        return view('user.index', compact('user', 'suggestedTutorial', 'averageTotalProgress'));
    }

    public function show()
    {
        $user = Auth::guard('user')->user();
        return view('user.show', compact('user'));
    }

    public function courses() {
        $tutorials = Auth::guard('user')?->user()?->tutorials;
        return view('user.courses', compact('tutorials'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);

        Auth::guard('user')->user()->name = $validatedData['name'];

        // Update password if provided
        if ($request->password) {
            Auth::guard('user')->user()->password = Hash::make($validatedData['password']);
        }

        if ($request->hasFile('profile_photo')) {
            $request->profile_photo->store('public/upload');
            Auth::guard('user')->user()->profile_photo = $request->profile_photo->hashName();
        }

        Auth::guard('user')->user()->save();
        return redirect()->route('user.profile')->with('success', 'پروفایل کاربری شما با موفقیت به روزرسانی شد');
    }
}
