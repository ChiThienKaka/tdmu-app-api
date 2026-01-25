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
        Schema::create('post_media', function (Blueprint $table) {
            $table->id('media_id');
            $table->unsignedBigInteger('post_id');
            //media_type ENUM('image', 'video', 'document')
            $table->string('media_type');
            $table->string('media_url');
            //public: Lưu local + public, s3: Lưu AWS S3, local:	Lưu nội bộ server
            $table->string('disk')->default('public');
            $table->unsignedInteger('media_order')->default(0);
            $table->timestamps();
            //FK
            $table->foreign('post_id')->references('post_id')->on('posts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_media');
    }
};
