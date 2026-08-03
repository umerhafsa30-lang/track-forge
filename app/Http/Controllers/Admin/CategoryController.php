<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'emoji' => 'nullable|string|max:10',
        ]);

        Category::create($validated);

        return back()->with('success', 'Category added successfully!');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'emoji' => 'nullable|string|max:10',
        ]);

        $category->update($validated);

        return back()->with('success', 'Category update ho gayi!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category delete ho gayi.');
    }
}
