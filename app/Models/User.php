<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

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

    public function emergencyRequests()
    {
        return $this->hasMany(EmergencyRequest::class);
    }

    public function emergencyDonates()
    {
        return $this->hasMany(EmergencyDonate::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function hospitalsRequest()
    {
        return $this->belongsToMany(Hospital::class, 'hospital_users');
    }

    public function userDiesese()
    {
        return $this->hasOne(UserDiesese::class);
    }

    public function isHospitalAdmin()
    {
        return $this->role == 1;
    }

    public function isAdmin()
    {
        return $this->role >= 2;
    }
    public function isSuperAdmin()
    {
        return $this->role == 3;
    }

    public function isEmployee()
    {
        return $this->hospital_id != null;
    }

    public function requestAvailability()
    {
        $user = HospitalUser::where("user_id",'=',$this->id)->get("done");
        if($user[0]->done == 1){
            return 1;
        }else{
            return 0;
        }
    }

    public function Aimodel()
    {
        return $this->hasOne(AiModel::class);
    }

}
