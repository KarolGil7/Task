<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiPostController extends Controller
{
    public function show()
    {
        $posts = Post::with('user')
            ->select('user_id', DB::raw('count(id) as total'))
            ->whereDate('updated_at', '>=', Carbon::today()->subDays(7)->toDateString())
            ->orderBy('total', 'asc')
            ->groupBy('user_id')
            ->get();
            
        $data = [];
        foreach ($posts as $key => $value)
        {
            $data[$key]['userName'] = $value->user->name;
            $data[$key]['total'] = $value->total;
        }

        return response()->json($data, 200);
    }
}
