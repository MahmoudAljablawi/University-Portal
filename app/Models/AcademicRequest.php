<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicRequest extends Model
{
    use HasFactory;

    protected $table = 'academic_requests';

    protected $fillable = [
        'student_id',
        'request_type',
        'reason',
        'status',
        'qr_code_token',
    ];

    // الطالب صاحب الطلب (مرتبط بجدول المستخدمين)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
