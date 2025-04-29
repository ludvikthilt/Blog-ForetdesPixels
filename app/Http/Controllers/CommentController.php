<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id'
        ]);
        
        $post = Post::findOrFail($request->post_id);
        
        $comment = new Comment([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'post_id' => $post->id
        ]);
        
        $comment->save();
        
        return redirect()->route('posts.show', $post)
            ->with('success', 'Votre commentaire a été publié avec succès!');
    }
    
    /**
     * Remove the specified comment from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        // Vérifier si l'utilisateur est autorisé à supprimer ce commentaire
        if (Auth::id() !== $comment->user_id && !Auth::user()->isAdmin()) {
            return redirect()->back()
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire.');
        }
        
        $post = $comment->post;
        $comment->delete();
        
        return redirect()->route('posts.show', $post)
            ->with('success', 'Le commentaire a été supprimé avec succès.');
    }
}