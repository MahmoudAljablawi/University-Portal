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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade'); // ربط الدرجة بتسجيل الطالب في الشعبة
            $table->decimal('midterm_grade', 5, 2)->nullable(); // درجة أعمال السنة / الفحص النصفي
            $table->decimal('final_grade', 5, 2)->nullable(); // درجة الامتحان النهائي
            $table->decimal('total_grade', 5, 2)->nullable(); // المجموع الكلي
            $table->string('letter_grade')->nullable(); // التقدير الحرفي (A, B, C...)
            $table->boolean('is_published')->default(false); // حالة الدرجة للطلاب
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};