<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    /**
     * Relation avec l'utilisateur qui a mis le like.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le post qui a reçu le like.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    
    /**
     * Ajouter un like à un post (si l'utilisateur n'a pas déjà liké ce post)
     */
    public static function toggleLike($userId, $postId)
    {
        $like = self::where('user_id', $userId)
            ->where('post_id', $postId)
            ->first();
        
        $post = Post::findOrFail($postId);
        
        if ($like) {
            // Si le like existe déjà, on le supprime
            $like->delete();
            $post->decrementLikesCount();
            return false;
        } else {
            // Sinon, on crée un nouveau like
            self::create([
                'user_id' => $userId,
                'post_id' => $postId
            ]);
            $post->incrementLikesCount();
            return true;
        }
    }
}