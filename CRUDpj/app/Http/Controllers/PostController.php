<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        $posts = Post::with(['category', 'user'])->latest()->get();
        return view('admin.viewpost', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.postcreate', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:posts,slug',
            'category_id' => 'required|exists:categories,id',
            'body'        => 'required|string',
        ]);

        $imagePath = null;
        // dd($request->all());
        if ($request->file('image')) {
            // dd('ddd');
            $imagePath = $request->file('image')->store('posts', 'public');
        }
        Post::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'slug'        => Str::slug($request->slug),
            'body'        => $request->body,
            'image'       => $imagePath,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.postcreate', compact('post', 'categories'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'body'        => 'required|string',
        ]);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'slug'        => Str::slug($request->slug),
            'body'        => $request->body,
            'image'       => $imagePath,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}