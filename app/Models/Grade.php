<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';

    protected $fillable = [
        'enrollment_id',
        'practical_grade',
        'theoretical_grade',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
        'approved_by',
        'approved_at',
        'published_at',
    ];

    protected $casts = [
        'practical_grade' => 'decimal:2',
        'theoretical_grade' => 'decimal:2',
        'reviewed_at' => 'datetime',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'total_grade',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getTotalGradeAttribute(): ?float
    {
        if (
            $this->practical_grade === null ||
            $this->theoretical_grade === null
        ) {
            return null;
        }

        return round(
            ((float) $this->practical_grade * 0.30) +
            ((float) $this->theoretical_grade * 0.70),
            2
        );
    }
}
