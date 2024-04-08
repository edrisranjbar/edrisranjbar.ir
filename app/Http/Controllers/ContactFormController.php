<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{

    public function index() {
        $forms = Contact::all();
        return view('admin.contactForm.index', compact('forms'));
    }

    public function store(Request $request) {
        $validatedData = $this->validate($request, [
            'name' => 'nullable',
            'email' => 'required|email',
            'message' => 'required'
        ]);
        Contact::create($validatedData);
        return back()->with('success', 'پیام شما با موفقیت ثبت شد');
    }
}
