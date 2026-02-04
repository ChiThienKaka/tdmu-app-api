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
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name', 100);
            $table->string('category_slug', 100)->unique();

            $table->unsignedBigInteger('parent_id')->nullable();

            $table->string('icon', 50)->nullable();
            $table->text('description')->nullable();

            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            // Foreign key self-reference (danh mục cha)
            $table->foreign('parent_id')
                ->references('category_id')
                ->on('job_categories')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_categories');
    }
};
