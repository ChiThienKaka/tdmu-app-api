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
        Schema::create('user_majors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('major_id');
            $table->string('class_name', 100)->nullable();
            $table->string('academic_year', 20)->nullable();
            $table->timestamps();
            // Composite Primary Key
            $table->primary(['user_id', 'major_id']);
            // FK
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->cascadeOnDelete();

            $table->foreign('major_id')
                  ->references('major_id')
                  ->on('majors')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_majors');
    }
};
