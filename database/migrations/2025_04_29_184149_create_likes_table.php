<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Ajouter un index unique pour éviter les doublons
            $table->unique(['user_id', 'post_id']);
        });
        
        // Ajouter la colonne likes_count à la table posts si elle n'existe pas déjà
        if (!Schema::hasColumn('posts', 'likes_count')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->integer('likes_count')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
        
        // Supprimer la colonne likes_count de la table posts
        if (Schema::hasColumn('posts', 'likes_count')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('likes_count');
            });
        }
    }
}