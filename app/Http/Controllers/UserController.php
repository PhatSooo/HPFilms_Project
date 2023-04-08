<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\History;
use App\Models\Movie_Review;
use App\Models\User_Favorite;
use App\Models\Movie_Rate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Query\JoinClause;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Facades\Voyager;

class UserController extends Controller
{
    // GET user page
    public function user_profile(){
        $title = 'User Profile';
        $user = User::where('id','=',Session::get('userId'))->first();
        return view('pages.user.userprofile', compact('title','user'));
    }

    // PUT change user info
    public function change_info(Request $request){
        $request->validate([
            'firstName' => 'required',
            'email' => 'required'
        ]);

        User::whereId(Session::get('userId'))->update([
            'email' => $request->email,
            'name' => $request->firstName. ' '. $request->lastName
        ]);

        return back()->with('user_status','Updated Successfully');
    }

    // PATCH change password
    public function change_pass(Request $request){
        // Validation
        $request->validate([
            'old_pass' => 'required',
            'new_pass' => 'required',
            'confirm_pass' => ['same:new_pass']
        ]);
        $user = User::where('id','=',Session::get('userId'))->first();

        // Match The Old Password
        if(!Hash::check($request->old_pass, $user->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }

        // Update the new Password
        User::whereId(Session::get('userId'))->update([
            'password' => Hash::make($request->new_pass)
        ]);
        return back()->with("status", "Password changed successfully!");
    }

    // GET
    public function user_rate(){
        $title = 'User Profile';
        $user = User::where('id','=',Session::get('userId'))->first();

        $review_rate = DB::table('movie_reviews')
            ->select('movie_reviews.created_at', 'movie_reviews.review', 'movie_rates.stars', 'movies.title', 'movies.date_release', 'movies.series', 'movies.slug', 'movies.image')
            ->rightJoin('movie_rates',function($join) {
                $join->on(function ($query) {
                    $query->where('movie_reviews.user_id','=',DB::raw('movie_rates.user_id'))
                        ->where('movie_reviews.movie_id','=',DB::raw('movie_rates.movie_id'));
                })
                ->orOn(function ($query) {
                    $query->whereNull('movie_reviews.movie_id')
                        ->whereNull('movie_reviews.user_id');
                });
            })
            ->join('movies','movie_rates.movie_id','=','movies.movie_id')
            ->where('movie_rates.user_id','=',$user->id)
            ->paginate(5,['*'],'list');

        // $review_rate = DB::select( 'select a.created_at,a.review, b.stars, c.title, c.date_release, c.series, c.slug, c.image from movie_reviews a right outer join movie_rates b
        //                             on (a.user_id = b.user_id and a.movie_id = b.movie_id)
        //                             or (a.movie_id is null and a.user_id is null)
        //                             join movies c on b.movie_id = c.movie_id
        //                             where b.user_id = ?',[$user->id]);
        return view('pages.user.userrate', compact('title','user','review_rate'));
    }

    // GET
    public function favorite_list(){
        $title = 'User Profile';
        $user = User::where('id','=',Session::get('userId'))->first();
        $favorites_list = User_Favorite::select('b.*')
                                ->join('movies as b','user_favorites.movie_id','=','b.movie_id')
                                ->where('user_favorites.user_id','=',$user->id)
                                ->paginate(9,['*'],'list');
        return view('pages.user.userfavoritelist', compact('title','user','favorites_list'));
    }

    // GET
    public function history(){
        $title = 'User Histories';
        $user = User::where('id','=',Session::get('userId'))->first();
        $histories = History::where('user_id',$user->id)
                            ->whereNull('deleted_at')
                            ->join('movies','histories.movie_id','=','movies.movie_id')
                            ->select('movies.movie_id','movies.series','movies.title','movies.slug','movies.image','movies.date_release','histories.updated_at','histories.id')
                            ->groupBy('movies.movie_id')
                            ->get();
        return view('pages.user.userhistory',compact('title','user','histories'));
    }

    public function remove_history(Request $request){
        $history_id = $request->history_id;
        History::where('id','=',$history_id)->update(['deleted_at' => Carbon::parse(date('Y-m-d H:i:s'))]);
    }

    // PUT change_img
    public function change_img(Request $request){
        $avatar_name = Str::random(20);
        $user = User::find($request->session()->get('userId'));
        $avatar_link = 'users/'.date("FY").'/'.$avatar_name.'.'.$request->avatar->getClientOriginalExtension();
        if (!$user->email_verified_at){
            return back()->with('failed', 'You must be verify your email first');
        }
        else { // Remove Old Image
            if(strcmp($user->avatar,'users/default.png') != 0) {
                $path = storage_path('app/public/'.$user->avatar);
                if (file_exists($path)) unlink($path); // Check old image and remove
            }
        }
        // Add image to public folder and database
        $request->file('avatar')->storeAs('public/users/'.date("FY"), $avatar_name.'.'.$request->avatar->getClientOriginalExtension());
        DB::table('users')->where('id',$user->id)->update(['avatar' => $avatar_link]);
        return back()->with('image_loaded', 'Change Avatar Successfully');
    }
}
