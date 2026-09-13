<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';

    protected $fillable = [
        'enrollment_id',
        'midterm_grade',
        'final_grade',
        'total_grade',
        'letter_grade',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'midterm_grade' => 'decimal:2',
        'final_grade' => 'decimal:2',
        'total_grade' => 'decimal:2',
    ];

    // الدرجة تنتمي إلى تسجيل طالب محدد في شعبة
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }
}
