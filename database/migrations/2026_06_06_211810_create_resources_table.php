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
        Schema::create('resources', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lesson_id')->nullable();
            $table->uuid('course_id')->nullable();
            $table->string('title');
            $table->string('file_url');       // Cloudinary URL
            $table->string('file_public_id'); // Cloudinary public_id
            $table->string('file_type');      // pdf, docx, etc.
            $table->bigInteger('file_size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
