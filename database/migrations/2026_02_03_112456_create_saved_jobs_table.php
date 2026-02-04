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
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->id('saved_job_id');

            // ===== Foreign keys =====
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('job_id');

            // ===== Data =====
            $table->text('note')->nullable();
            $table->timestamp('saved_at')->useCurrent();

            // ===== Constraints =====
            $table->unique(['user_id', 'job_id']);

            $table->index('user_id');
            $table->index('job_id');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('job_id')
                ->references('job_id')
                ->on('job_posts')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_jobs');
    }
};
