<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $fillable = [

        'name',
        'email',
        'password',
        'age',
        'phone',
        'gender',
        'blood_type',
        'location',
        'date_and_time',
        'request_id'
    ];
}
