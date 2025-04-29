<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Toggle like/unlike for a post.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function toggleLike(Post $post)
    {
        $isLiked = Like::toggleLike(Auth::id(), $post->id);
        
        if (request()->ajax()) {
            return response()->json([
                'isLiked' => $isLiked,
                'likesCount' => $post->fresh()->likes_count
            ]);
        }
        
        return redirect()->back()
            ->with('success', $isLiked ? 'Post liké avec succès!' : 'Like retiré avec succès!');
    }
}