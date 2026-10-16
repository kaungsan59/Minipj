<?php

namespace App\Http\Controllers;

use App\Models\Post;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        return view('user.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('user.show', compact('post'));
    }
}