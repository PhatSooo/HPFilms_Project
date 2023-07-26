<?php

namespace App\Console\Commands;

use App\Models\Genre;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Movie_Genre;

class GetMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all Movies from TMDB';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->getTopRate();
        $this->getUpcomming();
        $this->attachGenres();
        dd('Get Movies Successfully');
    }

    public function asd()
    {
        $respone = Http::connectTimeout(60)
            ->get(config('services.tmdb.base_url') . '/person/10980?api_key=' . config('services.tmdb.api_key'))
            ->throw()
            ->json();
        $production_country = $respone['production_countries'][0]['iso_3166_1'];
        $asd = array_map('trim', explode(',', $respone['place_of_birth']));
        dd($respone);
    }

    public function getTopRate()
    {
        for ($i = 1; $i < 6; $i++) {
            $respone = Http::get(config('services.tmdb.base_url') . '/movie/top_rated?api_key=' . config('services.tmdb.api_key') . '&page=' . $i);
            foreach ($respone->json()['results'] as $result) {
                $runtime = Http::connectTimeout(60)
                    ->get(config('services.tmdb.base_url') . '/movie/' . $result['id'] . '?api_key=' . config('services.tmdb.api_key'))
                    ->throw()
                    ->json();
                $movie = Movie::where('movie_id', $result['id'])->first();
                if (!array_key_exists('release_date', $result)) {
                    $result['release_date'] = now();
                }
                if (!$movie) {
                    $movie = Movie::create([
                        'movie_id' => $result['id'],
                        'title' => $result['title'],
                        'overview' => $result['overview'],
                        'date_release' => $result['release_date'],
                        'image' => $result['poster_path'],
                        'movie_status' => 1,
                        'runtime' => $runtime['runtime'],
                    ]);
                } else {
                    $movie->update([
                        'movie_id' => $result['id'],
                        'title' => $result['title'],
                        'overview' => $result['overview'],
                        'date_release' => $result['release_date'],
                        'image' => $result['poster_path'],
                        'movie_status' => 1,
                        'runtime' => $runtime['runtime'],
                    ]);
                }
            } //end of foreach
        } //end of for loop
    }

    public function getUpcomming()
    {
        $respone = Http::get(config('services.tmdb.base_url') . '/movie/upcoming?api_key=' . config('services.tmdb.api_key') . '&page=1');
        foreach ($respone->json()['results'] as $result) {
            $runtime = Http::connectTimeout(60)
                ->get(config('services.tmdb.base_url') . '/movie/' . $result['id'] . '?api_key=' . config('services.tmdb.api_key'))
                ->throw()
                ->json();
            $movie = Movie::where('movie_id', $result['id'])->first();
            if (!$movie) {
                $movie = Movie::create([
                    'movie_id' => $result['id'],
                    'title' => $result['title'],
                    'overview' => $result['overview'],
                    'date_release' => $result['release_date'],
                    'image' => $result['poster_path'],
                    'movie_status' => 3,
                    'runtime' => $runtime['runtime'],
                ]);
            } else {
                $movie->update([
                    'movie_id' => $result['id'],
                    'title' => $result['title'],
                    'overview' => $result['overview'],
                    'date_release' => $result['release_date'],
                    'image' => $result['poster_path'],
                    'movie_status' => 3,
                    'runtime' => $runtime['runtime'],
                ]);
            }
        } //end of foreach
    }

    private function attachGenres()
    {
        $movies = Movie::select('*')->get();
        foreach ($movies as $movie) {
            $genres = Http::get(config('services.tmdb.base_url') . '/movie/'.$movie->movie_id.'?api_key=' . config('services.tmdb.api_key'))->json();
            foreach ($genres['genres'] as $genreId) {
                $genre = Genre::where('genre_id', $genreId['id'])->first();
                $check = Movie_Genre::where('movie_id',$movie->movie_id)->where('genre_id',$genreId['id'])->first();
                if (!$check)
                    $movie->genres()->attach($genre->genre_id);
            }
        }
    }
}
