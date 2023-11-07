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
        $this->hasMany(User::class);
    }

    public function bloods()
    {
        return $this->belongsToMany(Blood::class, 'hospitals_blood');
    }
    public function requests()
    {
        return $this->hasMany(Request::class, 'sender_id');
    }
}
