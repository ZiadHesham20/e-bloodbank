<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalUser extends Model
{
    use HasFactory;

    public function blood()
    {
        $this->hasOne(Blood::class);
    }
}
