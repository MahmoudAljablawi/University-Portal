<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSemester extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'is_active',
        'registration_open',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'registration_open' => 'boolean',
    ];

    // الفصل الأكاديمي يحتوي على عدة شعب دراسية
    public function courseSections()
    {
        return $this->hasMany(CourseSection::class, 'semester_id');
    }
}