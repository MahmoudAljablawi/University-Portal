<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePrerequisite extends Model
{
    use HasFactory;

    protected $table = 'course_prerequisites';

    protected $fillable = [
        'course_id',
        'prerequisite_id',
    ];

    // المقرر الأساسي (المادة المشروطة)
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // المادة المتطلبة (المادة التي يجب إنجازها أولاً)
    public function prerequisiteCourse()
    {
        return $this->belongsTo(Course::class, 'prerequisite_id');
    }
}
