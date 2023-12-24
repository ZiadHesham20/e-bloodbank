<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalUser extends Model
{
    use HasFactory;

    public function blood()
    {
        return $this->belongsTo(Blood::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
