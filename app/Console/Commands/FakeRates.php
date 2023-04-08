<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Movie_Rate;
use Illuminate\Support\Facades\DB;

class FakeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate rates to db';

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

            //Get random number of wishlist
            $random = random_int(1,10);

            while ($i < $random){
                $userId = random_int(2,13);
                $db_rates = DB::table('movie_rates')->whereRaw('movie_id = '.$id->movie_id .' and user_id = '.$userId)->first();
                if ($db_rates == null) {
                    Movie_Rate::create([
                        'movie_id' => $id->movie_id,
                        'user_id' => $userId,
                        'stars' => random_int(1,10),
                    ]);
                    $i++;
                }
            }

        }
    }
}
