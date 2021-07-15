<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $table = 'users_companies';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'catchPhrase',
        'bs',
    ];

    public static function getByUserId(int $id = null)
    {
        $userCompany = UserCompany::where('user_id', '=', $id)->get();
        if(!$userCompany->isEmpty())
        {
            return $userCompany;
        }

        return null;
    }

}
