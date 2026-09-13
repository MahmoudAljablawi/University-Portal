<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';

    protected $fillable = [
        'user_id',
        'action',
        'target_table',
        'target_id',
        'description',
        'ip_address',
    ];

    // المستخدم الذي قام بالعملية المسجلة
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
