<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewCommentNotification;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, $postId)
    {
    $request->validate([
        'content' => 'required|string|max:300',
    ]);

    $post = Post::findOrFail($postId);

    $comment = Comment::create([
        'post_id' => $post->id,
        'user_id' => Auth::id(),
        'content' => $request->content,
    ]);

    // Notify the post owner
    if ($post->user_id !== Auth::id())
    {
        $post->user->notify(new NewCommentNotification($comment));
    }

    // Check if the request is AJAX
    if ($request->ajax()) 
    {
        // Return a JSON response with the comment data
        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment,
            'user' => Auth::user()->name,
            'created_at' => $comment->created_at->diffForHumans()
        ]);
    }

    return redirect()->route('dashboard')->with('success', 'Comment added successfully');
}

    // Delete a comment
    public function destroy(Comment $comment)
    {
        if (Auth::user()->id === $comment->user_id || Auth::user()->hasRole('admin')) {
            $comment->delete();
            return redirect()->back()->with('success', 'Comment deleted successfully.');
        }

        return redirect()->back()->with('error', 'You are not authorized to delete this comment.');
    }
}
