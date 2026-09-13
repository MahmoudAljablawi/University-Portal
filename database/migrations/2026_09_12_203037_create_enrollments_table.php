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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // الطالب المسجل
            $table->foreignId('section_id')->constrained('course_sections')->onDelete('cascade'); // الشعبة الدراسية
            $table->string('status')->default('enrolled'); // حالة التسجيل (enrolled, dropped, passed, failed)
            $table->timestamps();
            // منع تكرار تسجيل الطالب نفس الشعبة أكثر من مرة
            $table->unique(['student_id', 'section_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
