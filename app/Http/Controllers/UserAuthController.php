<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserAuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('user')->check()) {
            return redirect('/user');
        }
        return view('user.login');
    }


    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::firstOrCreate(
            ['email' => $credentials['email']],
            ['password' => bcrypt($credentials['password'])],
        );

        if (Auth::guard('user')->login($user, true)) {
            return redirect()->intended('/user');
        }

        return redirect()->route('user.login')->with('errors', ['usernameOrPassword' => 'نام کاربری یا رمز عبور اشتباه است!']);
    }


    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('user.login');
    }
}
