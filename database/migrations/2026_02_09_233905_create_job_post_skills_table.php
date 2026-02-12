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
        Schema::create('job_post_skills', function (Blueprint $table) {
            $table->id();
            // FK đến job_posts
            $table->unsignedBigInteger('job_id');

            // FK đến job_skills
            $table->unsignedBigInteger('skill_id');

            // Kỹ năng bắt buộc hay không
            $table->boolean('is_required')->default(true);

            // Mức độ thành thạo yêu cầu
            $table->enum('proficiency_level', [
                'beginner',
                'intermediate',
                'advanced',
                'expert'
            ])->nullable();

            $table->timestamps();

            // ================== INDEX ==================
            $table->index(['job_id', 'skill_id']);

            // ================== FOREIGN KEY ==================
            $table->foreign('job_id')
                ->references('job_id')
                ->on('job_posts')
                ->cascadeOnDelete();

            $table->foreign('skill_id')
                ->references('skill_id')
                ->on('job_skills')
                ->cascadeOnDelete();

            // Tránh trùng skill cho cùng 1 job
            $table->unique(['job_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post_skills');
    }
};
