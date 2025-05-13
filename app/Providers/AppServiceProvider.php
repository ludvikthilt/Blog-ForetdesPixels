<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use App\Models\Post;
use App\Observers\PostObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') == 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }
        
        // Enregistrer l'Observer pour les posts
        if (class_exists(Post::class) && class_exists(PostObserver::class)) {
            Post::observe(PostObserver::class);
        }
        
        // Désactiver la vérification SSL pour l'envoi d'emails
        // Vérifier d'abord que le mailer SMTP est configuré
        try {
            if (config('mail.default') === 'smtp' || config('mail.mailers.smtp.transport') === 'smtp') {
                $transport = Mail::mailer('smtp')->getSymfonyTransport();
                if (method_exists($transport, 'setStreamOptions')) {
                    $transport->setStreamOptions([
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ]
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Log the error but don't crash the application
            if (app()->bound('log')) {
                app('log')->warning('Unable to configure mail SSL settings: ' . $e->getMessage());
            }
        }
    }
}