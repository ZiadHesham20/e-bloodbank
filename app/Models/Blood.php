<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blood extends Model
{
    use HasFactory;

    protected $fillable = ['type'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'hospital_bloods');
    }
}
