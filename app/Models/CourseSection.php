<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    use HasFactory;

    protected $table = 'course_sections';

    protected $fillable = [
        'course_id',
        'semester_id',
        'instructor_id',
        'section_number',
        'capacity',
    ];

    // الشعبة تنتمي إلى مقرر دراسي واحد
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // الشعبة تنتمي إلى فصل أكاديمي واحد
    public function semester()
    {
        return $this->belongsTo(AcademicSemester::class, 'semester_id');
    }

    // الأستاذ المسؤول عن تدريس هذه الشعبة (مرتبط بجدول المستخدمين)
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // الطلاب المسجلون في هذه الشعبة
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'section_id');
    }
}