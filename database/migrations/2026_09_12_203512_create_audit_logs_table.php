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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // المستخدم الذي قام بالعملية
            $table->string('action'); // نوع العمليات (مثل: CREATE, UPDATE, DELETE, LOGIN)
            $table->string('target_table')->nullable(); // الجدول المتأثر بالعملية
            $table->unsignedBigInteger('target_id')->nullable(); // معرف السجل المتأثر
            $table->text('description')->nullable(); // وصف تفصيلي للحدث أو التغيير
            $table->string('ip_address')->nullable(); // عنوان الـ IP الخاص بالمستخدم
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};