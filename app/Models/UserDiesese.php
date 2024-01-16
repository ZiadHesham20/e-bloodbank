<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDiesese extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diseses()
    {
        return $this->belongsTo(Disease::class);
    }

    // public function hasDisese()
    // {
    //     return $this->hasDisese == 1;
    // }
}
