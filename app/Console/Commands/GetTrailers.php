<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GetTrailers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:trailers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Movie Trailer';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $movies = DB::table('movies')->select('movie_id')->get();
        foreach ($movies as $id){
            $respone = Http::connectTimeout(60)->get(config('services.tmdb.base_url').'/movie/'.$id->movie_id.'/videos?api_key='.config('services.tmdb.api_key'))->throw()->json();
            foreach ($respone['results'] as $result){
                if ($result['type'] == "Trailer"){
                    DB::table('movies')->where('movie_id',$id->movie_id)
                    ->update([
                        'trailer' => $result['key'],
                    ]);
                }
            }
        }
    }
}
