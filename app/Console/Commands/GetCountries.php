<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Country;

class GetCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all Countries';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $movies = Movie::select('*')->get();
        foreach ($movies as $movie) {
            $countries = Http::connectTimeout(60)->get(config('services.tmdb.base_url').'/movie/'.$movie->movie_id.'?api_key='.config('services.tmdb.api_key'))->throw()->json();
            if ($countries['production_countries']){
                $production_country = $countries['production_countries'][0]['iso_3166_1'];
                $country_id = $this->getCountries($production_country);
                $movie->update([
                    'production_country_id' => $country_id,
                ]);
            }
        }
    }

    private function getCountries($production_country){
        if (Country::where('country_name',$production_country)->first() == NULL){
            $id = Country::create([
                'country_name' => $production_country,
            ]);
            return $id->country_id;
        } else {
            return Country::select('country_id')->where('country_name',$production_country)->first()['country_id'];
        }
    }
}
