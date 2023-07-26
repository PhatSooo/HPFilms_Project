<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Crew;
use App\Models\Movie;

class GetCrews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:crews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all Crews';

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

            foreach ($respone['crew'] as $result){
                if ($i < 5){
                    if ($result['job'] == 'Director'){
                        $crews = Crew::where('crew_id',$result['id'])->first();
                        if(!$crews){
                            $get_nation = Http::connectTimeout(60)->get(config('services.tmdb.base_url').'/person/'.$result['id'].'?api_key='.config('services.tmdb.api_key'))->throw()->json();
                            $nation = array_map('trim',explode(',',$get_nation['place_of_birth']));
                            $crews = Crew::create([
                                'crew_id' => $result['id'],
                                'crew_name' => $result['name'],
                                'image' => $result['profile_path'],
                                'gender' => $result['gender'],
                                'position' => 1,
                                'nation' => last($nation),
                            ]);
                        }
                        $id->crews()->syncWithoutDetaching($crews->crew_id);
                    } // end if

                    elseif ($result['job'] == 'Novel' || $result['job'] == 'Storyboard Artist' || $result['known_for_department'] == 'Writing'){
                        $crews = Crew::where('crew_id',$result['id'])->first();
                        $get_nation = Http::connectTimeout(60)->get(config('services.tmdb.base_url').'/person/'.$result['id'].'?api_key='.config('services.tmdb.api_key'))->throw()->json();
                        $nation = array_map('trim',explode(',',$get_nation['place_of_birth']));
                        if(!$crews){
                            $crews = Crew::create([
                                'crew_id' => $result['id'],
                                'crew_name' => $result['name'],
                                'image' => $result['profile_path'],
                                'gender' => $result['gender'],
                                'position' => 2,
                                'nation' => last($nation),
                            ]);
                        }
                        $id->crews()->syncWithoutDetaching($crews->crew_id);
                    } // end elseif
                } // end if < 5
                $i++;
            } // end foreach
        }
        dd('Get Crews Successfully');
    }
}
