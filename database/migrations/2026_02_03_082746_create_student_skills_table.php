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
        Schema::create('student_skills', function (Blueprint $table) {
            $table->id('student_skill_id');

            // ===== Foreign keys =====
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('skill_id');

            // ===== Skill details =====
            $table->enum('proficiency_level', [
                'beginner',
                'intermediate',
                'advanced',
                'expert'
            ])->default('beginner');

            $table->decimal('years_of_experience', 3, 1)->nullable();

            // ===== Timestamp =====
            $table->timestamp('created_at')->useCurrent();

            // ===== Constraints =====
            $table->unique(['user_id', 'skill_id']);

            $table->index('user_id');
            $table->index('skill_id');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('skill_id')
                ->references('skill_id')
                ->on('job_skills')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_skills');
    }
};
