<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable , HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // إذا كان المستخدم أستاذًا، فهذه هي الشعب التي يحاضر فيها
    public function teachingSections()
    {
        return $this->hasMany(CourseSection::class, 'instructor_id');
    }

    // إذا كان المستخدم طالبًا، فهذه هي تسجيلاته في المقررات
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    // الطلبات الأكاديمية الخاصة بالطالب
    public function academicRequests()
    {
        return $this->hasMany(AcademicRequest::class, 'student_id');
    }

    // سجلات النظام الخاصة بهذا المستخدم
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}