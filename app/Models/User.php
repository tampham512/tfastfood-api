<?php

namespace App\Models;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Contracts\Auth\CanResetPassword;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;




class User extends Authenticatable implements CanResetPassword 
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table ='users';
    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
  
        'status',
        'role_as',
        'phone_number',
        'date_birth',
        'avata',
        'gender',
        'andress',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['roles'];

    public Function Roles()
    {
        return $this->belongsTo(Role::class,'role_as','id');
    }

    // public function sendPasswordResetNotification($token)
    // {
    //     $url = 'https://example.com/reset-password?token='.$token;
    
    //     $this->notify(new ResetPasswordNotification($url));
    // }

    
}