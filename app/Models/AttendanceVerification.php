<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceVerification extends Model
{
    use HasFactory;

    protected $table = 'attendance_verifications';
    protected $primaryKey = 'verification_id'; // Model correctly specifies verification_id
    public $timestamps = false;

    protected $fillable = [
        'attendance_id',
        'user_id',
        'request_type',
        'requested_time',
        'reason',
        'status',
        'admin_remark',
        'requested_at',
        'reviewed_at',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id', 'attendance_id');
    }

    // Added User relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}