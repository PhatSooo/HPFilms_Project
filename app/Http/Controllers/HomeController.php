<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\Movie_Rate;

class HomeController extends Controller
{
    private $data = [];

    public function index(){
        $title = 'Index';
        $new_movies = DB::select('select * from movies where movie_status = 1 and series is null order by created_at desc limit 10');
        $popular_movies = DB::select('select a.*, b.movie_id, count(b.movie_id) as views from movies a
                                join histories b on a.movie_id = b.movie_id
                                where a.series is null
                                group by b.movie_id
                                order by views DESC
                                limit 10');
        $coming_soon = DB::table('movies')->where('movie_status',3)->orderBy('date_release')->get();
        $theaters = DB::table('theaters')->where('status',true)->get();
        $top_rates = DB::select('select b.*, a.movie_id, count(a.movie_id) as views from movie_rates a
                                join movies b on a.movie_id = b.movie_id where b.series is null group by a.movie_id order by views DESC limit 10');
        $top_reviews = DB::select('select b.*, a.movie_id, count(a.movie_id) as reviews from movie_reviews a
                                join movies b on a.movie_id = b.movie_id where b.series is null
                                group by a.movie_id order by reviews DESC limit 10');
        $spot_celeb = DB::select('SELECT DISTINCT d.crew_id, d.crew_name, d.image, d.position, COUNT(b.crew_id) as views/*, COUNT(c.crew_id) as views*/ FROM histories a
                                    JOIN movie_casts b ON a.movie_id = b.movie_id
                                    JOIN movie_directors c ON a.movie_id = c.movie_id
                                    JOIN crews d ON (b.crew_id = d.crew_id OR c.crew_id = d.crew_id)
                                    GROUP BY d.crew_id
                                    ORDER BY views
                                    DESC limit 5');

        $list_rec = '';
        // if user is login get the last watched movie to recommend
        if (Session::has('userId')){
            $movie_id = DB::table('histories')->select('movie_id','updated_at')->where('user_id',Session::get('userId'))->orderBy('updated_at','desc')->first();
            $list_rec = new MovieController();
            $list_rec = $list_rec->Recommendation($movie_id->movie_id);
        }

        return view('pages.index', compact('list_rec','title','popular_movies','new_movies','theaters','coming_soon','top_rates','top_reviews','spot_celeb'));
    }

    public function movie_list(){
        $title = 'Movie List';
        $movies_list = Movie::select('*')->where('movie_status',1)->whereNull('series')->paginate(5,['*'],'list');
        $movies_grid = Movie::select('*')->where('movie_status',1)->whereNull('series')->paginate(16,['*'],'list');

        // GET genres for search
        $genres = DB::table('genres')->get();
        return view('pages.movielist', compact('title','movies_list','movies_grid','genres'));
    }

    public function series_list(){
        $title  = 'Single Seri';
        $movies = DB::table('series')->get();
        $get_slug = DB::table('movies')->select(['date_release','slug','series'])->whereNotNull('series')->orderBy('date_release')->groupBy('series')->get();

        // GET genres for search
        $genres = DB::table('genres')->get();
        return view('pages.serieslist', compact('title','movies','genres','get_slug'));
    }

    public function celeb_list(){
        $title = 'Celebrities List';
        $crews_list = DB::table('crews')->paginate(9,['*'],'list');
        $crews_grid = DB::table('crews')->paginate(9,['*'],'grid');
        $nations = DB::table('crews')->select('nation')->groupBy('nation')->get();
        // dd($nations->nation);
        return view('pages.celebritylist', compact('title','crews_list','crews_grid','nations'));
    }

    public function error(){
        $this->data['title'] = '404';
        return view('pages.404', $this->data);
    }
}
