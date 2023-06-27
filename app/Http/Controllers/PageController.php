<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Admin;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Admin::all();
        return view('admin.pages.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'nullable',
            'slug' => 'required|unique:pages',
            'author' => 'required',
        ]);
        Page::create($validatedData);
        return redirect()->route('pages.index')->with('success', 'صفحه جدید با موفقیت ایجاد شد.');
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $authors = Admin::all();
        $page = Page::findOrFail($id);
        return view('admin.pages.create', compact('page', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $page = Page::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'nullable',
            'slug' => 'required|unique:pages,slug,' . $id,
            'author' => 'required',
        ]);
        $page->update($validatedData);
        return redirect()->route('pages.index')->with('success', 'صفحه با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
    }
}
