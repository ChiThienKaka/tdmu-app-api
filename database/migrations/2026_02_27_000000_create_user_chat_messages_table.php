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
        Schema::create('user_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->comment('User gửi tin nhắn');
            $table->unsignedBigInteger('receiver_id')->comment('User nhận tin nhắn');
            $table->text('content')->comment('Nội dung tin nhắn');
            $table->boolean('is_read')->default(false)->comment('Đã đọc?');
            $table->timestamps();

            // Foreign keys
            $table->foreign('sender_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('receiver_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            // Indexes
            $table->index(['sender_id', 'receiver_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chat_messages');
    }
};
