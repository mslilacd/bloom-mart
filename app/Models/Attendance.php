<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';
    protected $primaryKey = 'attendance_id';
    public $timestamps = false; // Set to true if you have created_at/updated_at columns

    protected $fillable = [
        'user_id',
        'attendance_date',
        'time_in',
        'time_out',
        'total_hours',
    ];

    public function verifications()
    {
        return $this->hasMany(AttendanceVerification::class, 'attendance_id', 'attendance_id');
    }

    // Relationship to User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}