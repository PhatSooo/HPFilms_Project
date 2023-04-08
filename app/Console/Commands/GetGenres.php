<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Genre;

class GetGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all genres from TMDB';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $respone = Http::get(config('services.tmdb.base_url').'/genre/movie/list?api_key='.config('services.tmdb.api_key'));

        foreach ($respone->json()['genres'] as $genre){
            Genre::create([
                'genre_name' => $genre['name'],
                'genre_id' => $genre['id']
            ]);
        }
        dd('Get Genres Successfully');
    }
}
