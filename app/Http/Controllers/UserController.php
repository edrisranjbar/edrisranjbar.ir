<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.index');
    }

    public function show()
    {
        return view('user.show');
    }
}
