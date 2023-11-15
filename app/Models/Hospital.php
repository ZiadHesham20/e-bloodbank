<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function bloods()
    {
        return $this->belongsToMany(Blood::class, 'hospital_bloods');
    }

    public function usersRequest()
    {
        return $this->belongsToMany(User::class, 'hospital_users');
    }
}
