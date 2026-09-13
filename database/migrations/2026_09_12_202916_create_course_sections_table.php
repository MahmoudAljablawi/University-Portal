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
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // المقرر الدراسي
            $table->foreignId('semester_id')->constrained('academic_semesters')->onDelete('cascade'); // الفصل الأكاديمي
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null'); // الأستاذ المحاضر (مرتبط بجدول المستخدمين)
            $table->string('section_number'); // رقم أو رمز الشعبة (مثال: Sec-1)
            $table->integer('capacity'); // السعة القصوى للطلاب في الشعبة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_sections');
    }
};