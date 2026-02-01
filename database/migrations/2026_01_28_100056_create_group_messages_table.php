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
        Schema::create('group_messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->text('message_content')->nullable();
            // $table->enum('message_type', [
            //     'text',
            //     'image',
            //     'file',
            //     'link'
            // ])->default('text');
            // $table->text('media_url')->nullable();
            $table->unsignedBigInteger('reply_to_message_id')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
            //FK
             $table->foreign('group_id')
                  ->references('group_id')
                  ->on('groups')
                  ->cascadeOnDelete(); // group xoá -> tin nhắn xoá theo
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->cascadeOnDelete(); // user xoá -> tin nhắn xoá theo
            // Self reference (reply)
            $table->foreign('reply_to_message_id')
                  ->references('message_id')
                  ->on('group_messages')
                  ->nullOnDelete(); // tin gốc xoá -> reply không bị mất
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_messages');
    }
};
