<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'college_id'];

    // القسم ينتمي إلى كلية واحدة
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    // القسم يتبع له عدة مقررات دراسية
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
