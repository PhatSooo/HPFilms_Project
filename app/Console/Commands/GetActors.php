<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Movie_Cast;
use App\Models\Crew;
use App\Models\Movie;

class GetActors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:actors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all Actors';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $movies = Movie::select('*')->get();
        foreach ($movies as $id) {
            $respone = Http::connectTimeout(60)->get(config('services.tmdb.base_url').'/movie/'.$id->movie_id.'/credits?api_key='.config('services.tmdb.api_key'))->throw()->json();
            $i = 0;

            foreach ($respone['cast'] as $result){
                if ($i < 5){
                    if ($result['known_for_department'] == 'Acting'){
                        $actor = Crew::where('crew_id',$result['id'])->first();
                        if(!$actor){
                            $get_nation = Http::connectTimeout(60)->get(config('services.tmdb.base_url').'/person/'.$result['id'].'?api_key='.config('services.tmdb.api_key'))->throw()->json();
                            $nation = array_map('trim',explode(',',$get_nation['place_of_birth']));
                            $actor = Crew::create([
                                'crew_id' => $result['id'],
                                'crew_name' => $result['name'],
                                'image' => $result['profile_path'],
                                'gender' => $result['gender'],
                                'position' => 0,
                                'nation' => last($nation),
                            ]);
                        }
                        $id->actors()->syncWithoutDetaching($actor->crew_id);
                    } // end if
                } // end if < 5
                Movie_Cast::where('crew_id',$result['id'])->update([
                    'character_name' => $result['character'],
                ]);
                $i++;
            } // end foreach
        }
    }
}
