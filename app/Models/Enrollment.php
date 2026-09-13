<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $table = 'enrollments';

    protected $fillable = [
        'student_id',
        'section_id',
        'status',
    ];

    // الطالب المسجل (مرتبط بجدول المستخدمين)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // الشعبة الدراسية التي تم التسجيل فيها
    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'section_id');
    }

    // الدرجة المرتبطة بهذا التسجيل
    public function grade()
    {
        return $this->hasOne(Grade::class, 'enrollment_id');
    }
}