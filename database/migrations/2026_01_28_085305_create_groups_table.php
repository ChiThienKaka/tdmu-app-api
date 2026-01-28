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
        Schema::create('groups', function (Blueprint $table) {
            $table->id('group_id');
            $table->string('group_name', 255);
            $table->enum('group_type', [
                'faculty',
                'major',
                'class',
                'club',
                'public'
            ])->default('public');
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->unsignedBigInteger('major_id')->nullable();
            $table->text('description')->nullable();
            $table->text('avatar_url')->nullable();
            $table->text('cover_image')->nullable();
            $table->boolean('is_auto_join')->default(false);
            $table->enum('privacy', ['public', 'private', 'secret'])
                  ->default('public');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            //FK
            $table->foreign('faculty_id')->references('faculty_id')->on('faculties')
                ->onDelete('cascade');
            $table->foreign('major_id')->references('major_id')->on('majors')
                ->onDelete('cascade');
            $table->foreign('created_by')->references('user_id')->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
