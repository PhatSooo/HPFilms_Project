<?php

namespace App\Console\Commands;

use App\Models\History;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Movie_Rate;
use Illuminate\Support\Facades\DB;

class FakeHistories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:histories';

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
        $movies = DB::table('movies')->select('movie_id')->where('movie_status','!=',3)->get();

        foreach ($movies as $id){
            $i = 0;

            // get times views of film by random
            $times = random_int(1,20);

            while ($i < $times){
                // radom day
                $int = mt_rand(1232055681,1262055681);
                $day = date("Y-m-d H:i:s",$int);

                $random = random_int(2,13);

                History::create([
                    'movie_id' => $id->movie_id,
                    'user_id' => $random,
                    'updated_at' => $day,
                ]);
                $i++;
            }
        }
    }
}
