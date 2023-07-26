<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Movie_Review;
use App\Models\Movie_Rate;

class GetReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:reviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get reviews of films';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $movies = DB::table('movies')->select('movie_id')->get();
        foreach ($movies as $id){
            $i = 0;
            $respone = Http::connectTimeout(60)->get(config('services.tmdb.base_url').'/movie/'.$id->movie_id.'/reviews?api_key='.config('services.tmdb.api_key'))->throw()->json();

            $db_review = DB::table('movie_reviews')->where('movie_id',$id->movie_id)->first();
            if($db_review == null) {
                foreach ($respone['results'] as $result) {
                    if ($result != null && $i < 5){
                        Movie_Review::create([
                            'movie_id' => $id->movie_id,
                            'user_id' => random_int(2,13),
                            'review' => $result['content'],
                        ]);
                    } //end if
                    $i++;
                } //end foreach respone
            }

        } //end foreach movie_id
        dd('Get Reviews Successfully');
    }
}
