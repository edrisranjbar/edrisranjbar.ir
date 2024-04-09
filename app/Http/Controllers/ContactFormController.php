<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{

    public function index() {
        $forms = Contact::orderBy('created_at', 'desc')->paginate(10);
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

    public function destroy(int $id)
    {
        $form = Contact::findOrFail($id);
        $form->delete();
        return back()->with('success', 'پیام مورد نظر با موفقیت حذف شد');
    }

    public function destroyAll()
    {
        Contact::truncate();
        return back()->with('success', 'همه پیام ها با موفقیت حذف شدند');
    }
}
