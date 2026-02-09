<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_reactions', function (Blueprint $table) {
            $table->id('reaction_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            // ENUM('like', 'love', 'haha', 'wow', 'sad', 'angry')
            $table->string('reaction_type')->default('like'); 
            $table->timestamps();
            // Ensure a user can react only once per post
            $table->unique(['post_id', 'user_id']);

            // FK
            $table->foreign('post_id')->references('post_id')->on('posts')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_reactions');
    }
};
