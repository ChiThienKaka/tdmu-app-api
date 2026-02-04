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
        Schema::create('recruiter_companies', function (Blueprint $table) {
            $table->id('company_id');
            $table->unsignedBigInteger('user_id');

            $table->string('company_name', 255);
            $table->string('company_tax_code', 50)->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_phone', 20)->nullable();
            $table->string('company_email', 255)->nullable();
            $table->string('company_website', 255)->nullable();
            $table->text('company_logo')->nullable();

            $table->enum('company_size', [
                '1-10', '11-50', '51-200', '201-500', '500+'
            ])->default('1-10');

            $table->string('company_industry', 100)->nullable();
            $table->text('company_description')->nullable();

            // Verification
            $table->enum('verification_status', [
                'pending', 'verified', 'rejected'
            ])->default('pending');

            $table->json('verification_documents')->nullable();

            $table->timestamps();

            // FK
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->unique('user_id'); // mỗi recruiter chỉ có 1 company
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiter_companies');
    }
};
