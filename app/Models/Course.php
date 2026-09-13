<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'credits',
        'semester_level',
        'department_id',
    ];

    // المقرر ينتمي إلى قسم أكاديمي واحد
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // الشعب الدراسية التابعة لهذا المقرر
    public function sections()
    {
        return $this->hasMany(CourseSection::class);
    }

    // المتطلبات السابقة لهذا المقرر (المواد التي يجب على الطالب إنهاؤها أولاً)
    public function prerequisites()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisites', 'course_id', 'prerequisite_id');
    }

    // المقررات التي يعتبر هذا المقرر متطلباً سابقاً لها
    public function subsequentCourses()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisites', 'prerequisite_id', 'course_id');
    }
}