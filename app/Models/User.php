<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'street',
        'suite',
        'city',
        'zipcode',
        'lat',
        'lng',
        'phone',
        'website',
        'company_name',
        'company_catchPhrase',
        'company_bs',
    ];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getById(int $id = null)
    {
        $user = User::where('id', '=', $id)->get();
        if(!$user->isEmpty())
        {
            return $user;
        }

        return null;
    }

    public static function generateRandomString($length = 20) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}
