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
        Schema::create('student_notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->unsignedBigInteger('user_id');

            $table->enum('type', [
                'application_status',
                'interview_schedule',
                'new_job_match',
                'saved_job_expiring',
                'job_recommendation'
            ]);

            $table->string('title', 255);

            $table->text('content');

            $table->unsignedBigInteger('related_id')->nullable();

            $table->string('action_url', 255)->nullable();

            $table->boolean('is_read')->default(false);

            $table->timestamp('read_at')->nullable();

            $table->timestamp('created_at')->useCurrent();

            // FK tới users
            $table->foreign('user_id')
                ->references('user_id')   // mặc định Laravel users.id
                ->on('users')
                ->onDelete('cascade');

            // index tối ưu truy vấn
            $table->index('user_id');
            $table->index('type');
            $table->index('is_read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_notifications');
    }
};
