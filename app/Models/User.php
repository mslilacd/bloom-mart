<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false;
    
    protected $primaryKey = 'user_id';
    public $incrementing = true; // Add this line so Eloquent stops looking for an 'id' column

    protected $fillable = [
        'name',
        'ic_number',
        'email',
        'phone',
        'role',
        'start_date',
        'status',
        'password',
    ];
}