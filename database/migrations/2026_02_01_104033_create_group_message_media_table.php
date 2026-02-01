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
        Schema::create('group_message_media', function (Blueprint $table) {
            $table->id('group_message_media_id');
            $table->unsignedBigInteger('message_id');
            $table->text('media_url');
            $table->enum('media_type', ['image', 'video', 'file', 'audio']);
            $table->string('file_name', 255)->nullable();
            $table->string('disk', 50)->nullable()->default('public');
            $table->text('media_path')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();
            //FK
            $table->foreign('message_id')->references('message_id')->on('group_messages')
                ->onDelete('cascade');
            // Index tối ưu query chat
            $table->index('message_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_message_media');
    }
};
