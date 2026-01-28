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
        Schema::create('group_members', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('member_role', [
                'admin',
                'moderator',
                'member'
            ])->default('member');
            $table->timestamps();
            //primary key
            $table->primary(['group_id', 'user_id']);
            //FK
             $table->foreign('group_id')
                  ->references('group_id')
                  ->on('groups')
                  ->cascadeOnDelete(); // group bị xoá -> member bay theo
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->cascadeOnDelete(); // user bị xoá -> tự rời group
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_members');
    }
};
