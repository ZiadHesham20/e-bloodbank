<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalBlood extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'blood_id',
    ];

    public function blood()
    {
        return $this->belongsTo(Blood::class);
    }
}
