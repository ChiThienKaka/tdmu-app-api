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
        Schema::create('recruiter_packages', function (Blueprint $table) {
            $table->id('package_id');
            $table->string('package_name', 100);
            $table->decimal('price', 10, 2);
            $table->integer('duration_days');

            $table->integer('post_limit');
            $table->integer('featured_posts_limit')->default(0);
            $table->integer('refresh_limit')->default(0);

            $table->enum('support_priority', ['standard', 'priority', 'vip', 'premium'])
                  ->default('standard');

            $table->json('features')->nullable();

            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiter_packages');
    }
};
