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
        Schema::create('user_chat_message_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id')->comment('Message ID');
            $table->string('media_type')->comment('Loại media: image, video, file');
            $table->string('media_url')->comment('Đường dẫn media');
            $table->string('media_path')->comment('Path lưu trữ');
            $table->string('file_name')->comment('Tên file');
            $table->string('disk')->default('public')->comment('Disk lưu trữ');
            $table->unsignedBigInteger('file_size')->nullable()->comment('Kích thước file');
            $table->timestamps();

            // Foreign key
            $table->foreign('message_id')
                ->references('id')
                ->on('user_chat_messages')
                ->onDelete('cascade');

            // Index
            $table->index('message_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chat_message_media');
    }
};
