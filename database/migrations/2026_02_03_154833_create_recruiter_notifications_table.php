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
        Schema::create('recruiter_notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->unsignedBigInteger('subscription_id');

            $table->enum('type', [
                'new_application',
                'expiring_post',
                'package_expiring',
                'post_approved',
                'post_rejected',
                'new_review'
            ]);

            $table->string('title', 255);

            $table->text('content');

            $table->unsignedBigInteger('related_id')->nullable();

            $table->string('action_url', 255)->nullable();

            $table->boolean('is_read')->default(false);

            $table->timestamp('read_at')->nullable();

            $table->timestamp('created_at')->useCurrent();

            // Nếu bạn KHÔNG muốn updated_at thì không dùng $table->timestamps()

            // FK
            $table->foreign('subscription_id')
                ->references('subscription_id')
                ->on('recruiter_subscriptions')
                ->onDelete('cascade');

            // index để query nhanh
            $table->index('subscription_id');
            $table->index('type');
            $table->index('is_read');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiter_notifications');
    }
};
