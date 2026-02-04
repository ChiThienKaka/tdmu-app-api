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
        Schema::create('job_post_views', function (Blueprint $table) {
            $table->id('view_id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('session_id', 100)->nullable();

            $table->timestamp('viewed_at')->useCurrent();

            // ===== Indexes =====
            $table->index('job_id');
            $table->index('user_id');
            $table->index('viewed_at');

            // ===== Foreign keys =====
            $table->foreign('job_id')
                ->references('job_id')
                ->on('job_posts')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post_views');
    }
};
