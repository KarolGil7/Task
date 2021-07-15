<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

class getPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:getPosts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloading posts from the API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $logMsg = null;
        try {

            $response = Http::get('https://jsonplaceholder.typicode.com/posts');
            $data = $response->json();

            foreach ($data as $key => $value) {
                
                $rowPost = Post::getById($value["id"]);
                if ($rowPost == null) 
                {
                    $post = new Post();
                    $post->id = $value["id"];
                    $post->user_id = $value["userId"];
                    $post->title = $value["title"];
                    $post->body = $value["body"];
                    DB::transaction(function () use ($post) {
                        $post->save();
                    });
                }
                else
                {
                    $postToSave = [];
                    $postToSave["user_id"] = $value["userId"];
                    $postToSave["title"] = $value["title"];
                    $postToSave["body"] = $value["body"];

                    DB::transaction(function () use ($value, $postToSave) {
                        Post::where('id', '=', $value["id"])->update($postToSave);
                    });
                }

                DB::commit();
            }
            echo  "cron - getPosts - success";
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e->getMessage());
            echo  "cron - getPosts - error";
        }

        return 0;
    }

    public function report(Exception $exception)
    {
        echo 'report...';
        if ($exception instanceof CustomException) {
            //
        }

        parent::report($exception);
    }
}
