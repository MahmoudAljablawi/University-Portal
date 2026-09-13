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
        Schema::create('academic_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // الطالب صاحب الطلب
            $table->string('request_type'); // نوع الطلب (مثل: كشف علامات، إيقاف تسسجيل، اعتراض)
            $table->text('reason')->nullable(); // سبب الطلب أو تفاصيله
            $table->string('status')->default('pending'); // حالة الطلب (pending, approved, rejected)
            $table->string('qr_code_token')->nullable()->unique(); // رمز التحقق الخاص بالوثيقة المرتبطة بالطلب
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_requests');
    }
};