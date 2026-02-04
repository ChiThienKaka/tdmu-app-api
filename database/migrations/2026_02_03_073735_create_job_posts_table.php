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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id('job_id');
             // ===== Foreign keys =====
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('moderated_by')->nullable();

            // ===== Job info =====
            $table->string('job_title', 255);
            $table->string('slug', 255)->unique();

            $table->text('job_description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();

            // ===== Salary =====
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->enum('salary_type', [
                'hourly',
                'monthly',
                'yearly',
                'negotiable'
            ])->default('monthly');

            // ===== Job attributes =====
            $table->enum('job_type', [
                'fulltime',
                'parttime',
                'intern',
                'freelance',
                'contract'
            ])->default('fulltime');

            $table->enum('experience_level', [
                'intern',
                'fresher',
                'junior',
                '1-3years',
                '3-5years',
                '5+years'
            ])->default('fresher');

            $table->enum('education_level', [
                'high_school',
                'college',
                'bachelor',
                'master',
                'phd',
                'any'
            ])->default('bachelor');

            $table->integer('number_of_positions')->default(1);

            $table->enum('work_mode', [
                'onsite',
                'remote',
                'hybrid'
            ])->default('onsite');

            $table->enum('gender_requirement', [
                'male',
                'female',
                'any'
            ])->default('any');

            // ===== Location =====
            $table->string('location_province', 100)->nullable();
            $table->string('location_district', 100)->nullable();
            $table->text('location_address')->nullable();

            // ===== Application =====
            $table->date('application_deadline')->nullable();

            $table->string('contact_email', 255)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('contact_person', 100)->nullable();

            // ===== Display & status =====
            $table->boolean('is_featured')->default(false);
            $table->integer('priority_level')->default(0);

            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'rejected',
                'expired',
                'closed'
            ])->default('pending');

            $table->text('rejection_reason')->nullable();

            $table->timestamp('moderated_at')->nullable();

            // ===== Statistics =====
            $table->integer('view_count')->default(0);
            $table->integer('application_count')->default(0);

            $table->timestamp('last_refreshed_at')->nullable();
            $table->timestamp('published_at')->nullable();

            // ===== Timestamps =====
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')
                ->useCurrent()
                ->useCurrentOnUpdate();

            // ===== Indexes =====
            $table->index(['status', 'priority_level']);
            $table->index('category_id');
            $table->index('user_id');

            // ===== Foreign key constraints =====
            $table->foreign('subscription_id')
                ->references('subscription_id')
                ->on('recruiter_subscriptions')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('category_id')
                ->references('category_id')
                ->on('job_categories')
                ->nullOnDelete();

            $table->foreign('moderated_by')
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
        Schema::dropIfExists('job_posts');
    }
};
