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

            $table->foreignId('enrollment_id')
                ->unique()
                ->constrained('enrollments')
                ->cascadeOnDelete();

            $table->decimal('practical_grade', 5, 2)->nullable();
            $table->decimal('theoretical_grade', 5, 2)->nullable();

            $table->enum('status', [
                'draft',
                'submitted',
                'reviewed',
                'approved',
                'rejected',
                'published',
            ])->default('draft');

            // Rejection information
            $table->text('rejection_reason')->nullable();

            // Employee review
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();

            // Administration approval
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            // Publication
            $table->timestamp('published_at')->nullable();

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
