<?php

namespace App\Models;

use App\Http\Consts\Userconsts;
use GuzzleHttp\Promise\Create;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{


    use HasApiTokens, HasFactory, Notifiable;

    function getIsActiveAttribute($value){
        return $value ? "فعال": "غیرفعال";
    }

//    function setPasswordAttribute($value){
////        return $this->attributes['password']=Hash::make($value);
//    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
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


    function getRoleAttribute($value)
    {
        if ($value === Userconsts::USER) {
            return 'کاربر عادی';
        } elseif ($value === Userconsts::POSHTIBAN) {
            return ' پشتیبان';
        } else {
            return 'مدیر';
        }
    }
}
