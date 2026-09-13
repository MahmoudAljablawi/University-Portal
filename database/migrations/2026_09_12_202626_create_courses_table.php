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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique(); // (NET301)
            $table->text('description')->nullable();
            $table->integer('credits'); // عدد الساعات
            $table->integer('semester_level'); // المستوى الدراسي المقترح (السنة الأولى، الثانية...)
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade'); // القسم المسؤول عن المقرر
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
