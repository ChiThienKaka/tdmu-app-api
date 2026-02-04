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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id('application_id');
             // ===== Foreign keys =====
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('reviewed_by')->nullable();

            // ===== Applicant info =====
            $table->string('full_name', 255);
            $table->string('email', 255);
            $table->string('phone', 20);

            $table->text('cv_url')->nullable();
            $table->text('cover_letter')->nullable();

            // ===== Application status =====
            $table->enum('status', [
                'pending',
                'reviewed',
                'shortlisted',
                'interviewed',
                'offered',
                'accepted',
                'rejected',
                'withdrawn'
            ])->default('pending');

            $table->text('note')->nullable();
            $table->unsignedTinyInteger('rating')->nullable(); // 1–5

            $table->text('rejection_reason')->nullable();

            // ===== Interview =====
            $table->dateTime('interview_schedule')->nullable();
            $table->text('interview_location')->nullable();

            $table->enum('interview_status', [
                'scheduled',
                'completed',
                'cancelled',
                'rescheduled'
            ])->nullable();

            // ===== Review tracking =====
            $table->timestamp('reviewed_at')->nullable();

            // ===== Timestamps =====
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('updated_at')
                ->useCurrent()
                ->useCurrentOnUpdate();

            // ===== Indexes =====
            $table->index(['job_id', 'status']);
            $table->index('user_id');
            $table->index('applied_at');

            // ===== Constraints =====
            $table->foreign('job_id')
                ->references('job_id')
                ->on('job_posts')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('reviewed_by')
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
        Schema::dropIfExists('job_applications');
    }
};
