<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();

        return view('admin.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $categories = Category::latest()->get();
        return view('admin.category', compact('categories', 'category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}