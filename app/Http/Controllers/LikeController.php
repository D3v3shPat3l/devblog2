<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleLike(Post $post)
    {
        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            // Unlike the post if already liked
            $like->delete();
        } else {
            // Like the post
            $post->likes()->create(['user_id' => auth()->id()]);
        }

        return back();
    }
}