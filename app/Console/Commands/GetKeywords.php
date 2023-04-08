<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Movie_Keyword;
use App\Models\Keyword;
use App\Models\Movie;

class GetKeywords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:keywords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all Keywords';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $movies = Movie::select('*')->get();
        foreach ($movies as $id) {
            $i = 0;
            $respone = Http::connectTimeout(60)
                ->get(config('services.tmdb.base_url') . '/movie/' . $id->movie_id . '/keywords?api_key=' . config('services.tmdb.api_key'))
                ->throw()
                ->json();

            // $db_review = DB::table('movie_reviews')->where('movie_id',$id->movie_id)->first();
            foreach ($respone['keywords'] as $result) {
                if ($result['id'] != null){
                    $key = DB::table('keywords')->where('keyword_id',$result['id'])->first();
                    if ($key == null && $i < 3){
                        $movie = Movie::where('movie_id',$id->movie_id)->first();
                        Keyword::create([
                            'keyword_id' => $result['id'],
                            'keyword_name' => $result['name'],
                        ]);
                        $i++;
                        $this->attachKeywords($result,$movie);
                    }
                }
            } //end foreach respone
        } //end foreach movie_id
    }

    private function attachKeywords($result,Movie $movie){
        $keyword = Keyword::where('keyword_id',$result['id'])->first();
        $movie->keywords()->attach($keyword->keyword_id);
    }
}
