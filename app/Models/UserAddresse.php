<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddresse extends Model
{
    protected $table = 'users_addresses';
    public $timestamps = true;

    protected $fillable = [
        'street',
        'suite',
        'city',
        'zipcode',
        'lat',
        'lng',
    ];

    public static function getByUserId(int $id = null)
    {
        $userAddresse = UserAddresse::where('user_id', '=', $id)->get();
        if(!$userAddresse->isEmpty())
        {
            return $userAddresse;
        }

        return null;
    }
    
}
