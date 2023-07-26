<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User_Favorite;
use Illuminate\Support\Facades\DB;

class FakeWishlist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:wishlist';

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
            //Get random number of wishlist
            $random = random_int(1,10);

            while ($i < $random){
                $user_id = random_int(2,13);

                $check = User_Favorite::where('user_id',$user_id)->where('movie_id',$id->movie_id)->first();
                if ($check == null){
                    User_Favorite::create([
                        'movie_id' => $id->movie_id,
                        'user_id' => $user_id,
                    ]);
                    $i++;
                }
            }
        }
        dd('Fake Wishlist Successfully');
    }
}
