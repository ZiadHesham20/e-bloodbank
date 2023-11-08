<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function blood()
    {
        return $this->hasOne(Blood::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function diseases()
    {
        return $this->belongsToMany(Disease::class, 'user_diseases');
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'user_medicines');
    }

    public function hospitalsRequest()
    {
        return $this->belongsToMany(Hospital::class, 'hospital_users');
    }
}
