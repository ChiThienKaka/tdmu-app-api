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
        Schema::create('student_profiles', function (Blueprint $table) {
            // ===== Primary key & FK =====
            $table->unsignedBigInteger('user_id')->primary();

            // ===== Academic info =====
            $table->string('student_code', 50)->nullable();
            $table->string('university', 255)->nullable();
            $table->string('major', 100)->nullable();
            $table->year('graduation_year')->nullable();
            $table->decimal('gpa', 3, 2)->nullable(); // tối đa 4.00

            // ===== CV & links =====
            $table->text('cv_default_url')->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('github_url', 255)->nullable();
            $table->string('portfolio_url', 255)->nullable();

            // ===== Profile content =====
            $table->text('bio')->nullable();
            $table->text('career_goals')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // ===== Job preference =====
            $table->decimal('expected_salary_min', 10, 2)->nullable();
            $table->decimal('expected_salary_max', 10, 2)->nullable();

            // $table->set('preferred_job_type', [
            //     'fulltime',
            //     'parttime',
            //     'intern',
            //     'freelance'
            // ])->nullable();
            $table->jsonb('preferred_job_type')->nullable();
            $table->json('preferred_location')->nullable();

            $table->boolean('is_public')->default(true);

            // ===== Timestamps =====
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')
                ->useCurrent()
                ->useCurrentOnUpdate();

            // ===== Constraint =====
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
