<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Show the dashboard page with all posts and comments
    public function index()
    {
        $posts = Post::with(['comments.user', 'user'])->latest()->get();
        return view('dashboard', compact('posts'));
    }

    // Store a new post
    public function store(Request $request)
    {
    $request->validate([
        'title' => 'required|string|max:255',  // Add title validation
        'content' => 'required|string|max:500',
    ]);

    Post::create([
        'user_id' => Auth::id(),
        'title' => $request->title,   // Add title to the creation array
        'content' => $request->content,
    ]);

    return redirect()->route('dashboard')->with('success', 'Post created successfully');
    }
}
