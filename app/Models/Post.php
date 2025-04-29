<?php

/* namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'body', 'enabled', 'published_at', 'user_id', 'image', 'thumbImage'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} */


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 
        'body', 
        'enabled', 
        'published_at', 
        'user_id', 
        'image', 
        'thumbImage',
        'likes_count' // Compteur de likes
    ];

    protected $attributes = [
        'likes_count' => 0, // Valeur par défaut pour le compteur de likes
    ];

    /**
     * Relation avec l'utilisateur qui a créé le post
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les commentaires du post
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Relation avec les likes du post
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Retourne le nombre de likes pour ce post
     */
    public function getLikesCountAttribute()
    {
        return $this->attributes['likes_count'] ?? 0;
    }

    /**
     * Incrémente le compteur de likes
     */
    public function incrementLikesCount()
    {
        $this->increment('likes_count');
    }

    /**
     * Décrémente le compteur de likes
     */
    public function decrementLikesCount()
    {
        $this->decrement('likes_count');
    }
}