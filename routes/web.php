<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckPostOwner;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Display List of posts
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/table', [PostController::class, 'showPostsTable'])->name('posts.postsTable');

// Show form to Enter post data
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('auth');

// Show Trashed Posts
Route::get('posts/trash', [PostController::class, 'showTrashedPosts'])->name('posts.trash');

Route::post('posts', [PostController::class, 'store'])->name('posts.store'); //save data

// Get info about specific post
Route::get('posts/{id}', [PostController::class, 'show'])->name('posts.show')->where('id', '[0-9]+');

// Show edit form for specific post
Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit')->where('id', '[0-9]+')->middleware(CheckPostOwner::class);

// Update specific post
Route::put('posts/{id}', [PostController::class, 'update'])->name('posts.update')->where('id', '[0-9]+');

// Delete specific post
Route::delete('posts/{id}', [PostController::class, 'destroy'])->name("posts.destroy")->where('id', '[0-9]+');

Route::get('users', [UserController::class, 'index'])->name('users.index');

// Error Page
Route::fallback(fn () => view('error'));

// Routes pour les commentaires
Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

// Route pour les likes
Route::post('/posts/{post}/like', [App\Http\Controllers\LikeController::class, 'toggleLike'])->name('posts.like');

// Route pour le profil utilisateur
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
// Route pour les mails
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

// Ajoutez cette route dans routes/web.php pour tester l'envoi d'email
Route::get('/test-email', function () {
    try {
        $details = [
            'name' => 'Test Utilisateur',
            'email' => 'test@example.com',
            'message' => 'Ceci est un message de test pour vérifier la fonctionnalité d\'envoi d\'email.'
        ];
        
        Mail::to('ludviktybho@gmail.com')->send(new App\Mail\ContactFormMail($details));
        
        return "Email envoyé avec succès! Vérifiez votre boîte de réception.";
    } catch (\Exception $e) {
        return "Erreur lors de l'envoi de l'email: " . $e->getMessage();
    }
});

