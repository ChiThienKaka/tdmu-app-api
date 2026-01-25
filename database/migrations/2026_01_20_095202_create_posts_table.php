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
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->unsignedBigInteger('major_id')->nullable();
            // Nội dung bài viết
            $table->text('content');
            // ENUM -> string
            $table->string('post_type')->default('normal');
            // Phạm vi hiển thị
            $table->string('visibility')->default('public');
            // Trạng thái kiểm duyệt
            $table->string('status', 30)->default('pending');
            // Lý do từ chối (nếu có)
            $table->text('rejection_reason')->nullable();
            // Số lượt xem
            $table->unsignedInteger('view_count')->default(0);
            // thời gian admin kiểm duyệt
            $table->timestamp('moderated_at')->nullable();
            // người kiểm duyệt
            $table->unsignedBigInteger('moderated_by')->nullable();
            $table->timestamps();
            
            //Foreign
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('faculty_id')->references('faculty_id')->on('faculties')->onDelete('cascade');
            $table->foreign('major_id')->references('major_id')->on('majors')->onDelete('cascade');
            $table->foreign('moderated_by')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
