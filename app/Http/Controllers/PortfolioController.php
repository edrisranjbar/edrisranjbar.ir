<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::latest()->paginate(10);
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('admin.portfolios.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'status' => 'required|in:public,private,draft',
        ]);
        if ($request->hasFile('thumbnail')) {
            $request->thumbnail->store('public/upload');
            $validatedData['thumbnail'] = $request->thumbnail->hashName();
        }
        Portfolio::create($validatedData);
        return redirect()->route('portfolios.index')->with('success', 'نمونه کار جدید با موفقیت ذخیره شد.');
    }

    public function edit(int $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, int $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'status' => 'required|in:public,private,draft',
        ]);

        // Update the thumbnail if provided
        if ($request->hasFile('thumbnail')) {
            $request->thumbnail->store('public/upload');
            $validatedData['thumbnail'] = $request->thumbnail->hashName();
        }

        $portfolio->update($validatedData);
        return redirect()->route('portfolios.index')->with('success', 'نمونه کار با موفقیت بروزرسانی شد.');
    }

    public function destroy(int $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $portfolio->delete();
        return redirect()->route('portfolio.index')
            ->with('success', 'نمونه کار با موفقیت حذف شد.');
    }
}
