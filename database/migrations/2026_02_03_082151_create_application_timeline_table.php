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
        Schema::create('application_timeline', function (Blueprint $table) {
            $table->id('timeline_id');
            // ===== Foreign keys =====
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('changed_by')->nullable();

            // ===== Status tracking =====
            $table->string('old_status', 50)->nullable();
            $table->string('new_status', 50);

            $table->text('note')->nullable();

            // ===== Timestamp =====
            $table->timestamp('created_at')->useCurrent();

            // ===== Indexes =====
            $table->index('application_id');
            $table->index('created_at');

            // ===== Constraints =====
            $table->foreign('application_id')
                ->references('application_id')
                ->on('job_applications')
                ->cascadeOnDelete();

            $table->foreign('changed_by')
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
        Schema::dropIfExists('application_timeline');
    }
};
