<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blood()
    {
        return $this->belongsTo(Blood::class);
    }

    public function emergencyDonates()
    {
        return $this->hasMany(EmergencyDonate::class);
    }
}
