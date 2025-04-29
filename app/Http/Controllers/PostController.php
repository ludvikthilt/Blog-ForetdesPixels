<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Events\PostDeleted;
use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Routes publiques accessibles sans connexion
        $this->middleware('auth')->except(['index', 'show']);
        
        // Routes réservées aux administrateurs
        $this->middleware('admin')->only([
            'create', 'store',           // Création de posts
            'trash', 'postsTable',       // Gestion avancée
            'restore'                    // Restauration de posts
        ]);
    }

        /**
     * Vérifie si l'utilisateur peut modifier ou supprimer un post spécifique
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    protected function authorizePostOwner(Post $post)
    {
        // Si l'utilisateur n'est pas l'auteur du post et n'est pas administrateur
        if (Auth::id() !== $post->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Non autorisé. Vous n\'êtes pas l\'auteur de ce post.');
        }
    }

    public function index()
    {
        // User::factory(10)->create();
        $posts = Post::with('user')->paginate(9);
        return view("posts.index", ['posts' => $posts]);
    }

    public function showPostsTable()
    {
        $posts = Post::paginate(10);
        return view('posts.postsTable', ['posts' => $posts]);
    }

    public function show(string $id)
    {
        $post = Post::with('user')->find($id);
        return view('posts.show', ['post' => $post]);
    }

    public function showTrashedPosts()
    {
        $trashedPosts = Post::onlyTrashed()->get();
        return view('posts.trash', ['trashedPosts' => $trashedPosts]);
    }

    public function create()
    {
        return view("posts.create");
    }

    public function store(StorePost $request)
    {
        event(new PostCreated(Auth::id()));
        $imgPath = '';
        if ($request->has('image') && $request->file('image')->isValid()) {
            $imgPath = $request->file('image')->store('posts', ['disk' => 'public']);
        }

        $thumbPath = '';
        if ($request->has('thumbImage') && $request->file('thumbImage')->isValid()) {
            $thumbPath = $request->file('thumbImage')->store('posts', ['disk' => 'public']);
        }

        Post::create(['title' => $request->title, 'body' => $request->body, 'enabled' => $request->enabled, 'published_at' => Carbon::now(), 'user_id' => Auth::id(), 'image' => $imgPath, 'thumbImage' => $thumbPath]);
        return redirect()->route('posts.postsTable')->with('success', 'Post Added successfully');
    }

    public function edit(string $id)
    {
        $this->authorizePostOwner($post);
        $post = Post::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
    }

    public function update(UpdatePostRequest $request, string $id)
    {
        $this->authorizePostOwner($post);

        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'enabled' => 'required'
        ]);

        Post::find($id)->update(['title' => $request->title, 'body' => $request->body, 'enabled' => $request->enabled]);
        return redirect()->route('posts.postsTable', ['success' => 'Post updated successfully']);
    }

    public function destroy(string $id)
    {
        $this->authorizePostOwner($post);
        event(new PostDeleted(Auth::id()));
        Post::find($id)->delete();
        return redirect()->route('posts.postsTable')->with('success', 'Post deleted successfully');
    }
}
