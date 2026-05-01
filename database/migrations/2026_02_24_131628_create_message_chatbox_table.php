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
        Schema::create('message_chatbox', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id');
            $table->enum('role', ['user', 'assistant']); 
            $table->text('content');
            //lưu dữ liệu job đã tìm được
            $table->json('job_ids')->nullable();
            $table->jsonb('jobs')->nullable();
            $table->timestamps();
            //FK
            $table->foreignId('user_id')
            ->constrained('users', 'user_id')
            ->onDelete('cascade');
        });

        // thêm cột array PostgreSQL
        // DB::statement('ALTER TABLE message_chatbox ADD COLUMN job_ids INTEGER[]');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_chatbox');
    }
};
