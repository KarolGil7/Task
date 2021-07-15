<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'title',
        'body',
    ];

    public static function getById(int $id = null)
    {
        $posts = Post::where('id', '=', $id)->get();
        if(!$posts->isEmpty())
        {
            return $posts;
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
