<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPostNotification;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        // Vérifier si le post est activé et publié
        if ($post->enabled && $post->published_at !== null) {
            $this->sendNewPostNotification($post);
        }
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        // Si le post vient d'être activé et publié
        if ($post->enabled && $post->published_at !== null && 
            (!$post->getOriginal('enabled') || $post->getOriginal('published_at') === null)) {
            $this->sendNewPostNotification($post);
        }
    }

    /**
     * Envoie des notifications par e-mail pour un nouveau post
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    private function sendNewPostNotification(Post $post)
    {
        try {
            // Récupérer tous les utilisateurs
            $users = User::all();
            
            foreach ($users as $user) {
                Mail::to($user->email)
                    ->send(new NewPostNotification($post));
            }
        } catch (\Exception $e) {
            // Silencieux en cas d'erreur
        }
    }
}