<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'location_id',
        'role_id',
        'factory_id',
        'device_id',
        'type',
        'address',
        'local_govt',
        'device_id',
        'state',
        'gender',
        'bank_name',
        'account_number',
        'account_name',
        'wallet',
        'pin',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function role()
    {
        return $this->belongsTo(UserRole::class);
    }
    public function factory()
    {
        return $this->hasOne(Factory::class);
    }
    public function dropoff()
    {
        return $this->hasOne(DropOff::class,'user_id');
    }

    public function collect()
    {
        return $this->hasOne(Collection::class,'user_id');
    }



    public function e_money()
    {
        return $this->hasOne(EMoney::class,'user_id');
    }


}
