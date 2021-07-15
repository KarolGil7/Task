<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostController extends Controller
{
    public function index()
    {
        return view('post.index', [
            'posts' => Post::with('user')->paginate(5)
        ]);
    }
}
