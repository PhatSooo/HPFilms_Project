<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    public function movies($category,$term){
        $genres = DB::table('genres')->get();

        //search by name
        if ($category == 'movie-name'){
            $search = DB::table('movies')->whereRaw('title like "%'.$term.'%"')->paginate(5,['*'],'list');
        }
        //search by genre
        elseif ($category == 'genre-name'){

            $term = array_map('intval', explode(',', $term));
            $search = DB::table('movie_genres')->select('movies.*')
                            ->join('movies','movies.movie_id','=','movie_genres.movie_id')
                            ->whereIn('movie_genres.genre_id',$term)
                            ->groupBy('movie_genres.movie_id')
                            ->paginate(5,['*'],'list');
        }
        //search by rate range
        elseif ($category == 'rate-range'){
            switch ($term) {
                case 'under5':
                    $search = DB::table('movie_rates')->select(['movies.*',DB::raw('avg(stars) as avg_star')])
                            ->join('movies','movie_rates.movie_id','=','movies.movie_id')
                            ->groupBy('movie_rates.movie_id')
                            ->having('avg_star','<',5)
                            ->paginate(5,['*'],'list');
                    break;
                case '5to8':
                    $search = DB::table('movie_rates')->select(['movies.*',DB::raw('avg(stars) as avg_star')])
                            ->join('movies','movie_rates.movie_id','=','movies.movie_id')
                            ->groupBy('movie_rates.movie_id')
                            ->havingBetween('avg_star',[5,8])
                            ->paginate(5,['*'],'list');
                    break;
                case 'upper8':
                    $search = DB::table('movie_rates')->select(['movies.*',DB::raw('avg(stars) as avg_star')])
                            ->join('movies','movie_rates.movie_id','=','movies.movie_id')
                            ->groupBy('movie_rates.movie_id')
                            ->having('avg_star','>',8)
                            ->paginate(5,['*'],'list');
                    break;
            }
        }
        //search by year range
        elseif ($category == 'year-range'){
            $term = array_map('intval', explode('-', $term));
            $search = DB::table('movies')->whereBetween(DB::raw('year(date_release)'),$term)->paginate(5,['*'],'list');
        }
        //search by actor or crew
        else{
            $crews = DB::table('crews')->where('crew_id',$term)->select('position')->first();
            if ($crews->position == 0){
                $search = DB::table('crews')->select('movies.*')
                            ->join('movie_casts','crews.crew_id','=','movie_casts.crew_id')
                            ->join('movies','movie_casts.movie_id','=','movies.movie_id')
                            ->where('crews.crew_id',$term)
                            ->paginate(5,['*'],'list');
            }
            else {
                $search = DB::table('crews')->select('movies.*')
                            ->join('movie_directors','crews.crew_id','=','movie_directors.crew_id')
                            ->join('movies','movie_directors.movie_id','=','movies.movie_id')
                            ->where('crews.crew_id',$term)
                            ->paginate(5,['*'],'list');
            }
        }

        return view('pages.search')->with(['search' => $search, 'genres' => $genres]);
    }

    // POST movies search
    public function movie_search(Request $request){
        $name = $request->movie;
        $genres = $request->genres;
        $rates = $request->rates;
        $fYear = $request->fYear;
        $tYear = $request->tYear;
        $crewId = $request->crewId;
        if ($name) {
            return redirect()->route('search',['category' => 'movie-name', 'term' => $name]);
        } else if ($genres){
            $s = implode(',',$genres);
            return redirect()->route('search', ['category' => 'genre-name', 'term' => $s]);
        } else if ($rates){
            return redirect()->route('search', ['category' => 'rate-range', 'term' => $rates]);
        } else if ($fYear && $tYear) {
            $s = $fYear.'-'.$tYear;
            return redirect()->route('search', ['category' => 'year-range', 'term' => $s]);
        } else {
            return redirect()->route('search', ['category' => 'crew-name', 'term' => $crewId]);
        }
    }

    public function celebs($category,$term){
        $nations = DB::table('crews')->select('nation')->groupBy('nation')->get();

        //Search Crew Name
        if ($category == 'crew-name'){
            $search = DB::table('crews')->whereRaw('crew_name like "%'.$term.'%"');
        }

        //Search Cate Crews
        else if ($category == 'cate-name'){
            switch ($term) {
                case '0_1': // Actress
                    $search = DB::table('crews')->where('position','=',0)->where('gender','=','0');
                    break;
                case '0_2': // Actors
                    $search = DB::table('crews')->where('position','=',0)->where('gender','=','1');
                    break;
                case '1': // Directors
                    $search = DB::table('crews')->where('position','=',1);
                    break;
                case '2': // Writers
                    $search = DB::table('crews')->where('position','=',2);
                    break;
            }
        }

        //Search nation
        else {
            $search = DB::table('crews')->where('nation','=',$term);
        }

        return view('pages.search_celeb')->with(['search' => $search->paginate(5,['*'],'list'), 'nations' => $nations]);
    }

    // POST crews search
    public function crews_search(Request $request){
        $name = $request->name;
        $cate = $request->cate;
        $nation = $request->nation;

        if ($name) {
            return redirect()->route('celeb_search',['category' => 'crew-name', 'term' => $name]);
        } else if ($cate){
            return redirect()->route('celeb_search',['category' => 'cate-name', 'term' => $cate]);
        } else{
            return redirect()->route('celeb_search',['category' => 'nation-name', 'term' => $nation]);
        }
    }
}
