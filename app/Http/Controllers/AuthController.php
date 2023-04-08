<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request){
        $user = DB::table('users')->where('email',$request->email)->first();
        if ($user){
            if (Hash::check($request->password,$user->password)){
                $request->session()->put('userId', $user->id);
                $request->session()->put('userName', $user->name);
                return back();
            } else
                return back()->with('login_fail',true);
        }
        return back()->with('login_fail',true);
    }

    public function register(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $res = $user->save();

        if($res) return back()->with('success');
        else return back()->with('fail');
    }

    public function logout(){
        if (Session::has('userId')){
            Session::pull('userId');
            Session::pull('userName');
            return back();
        }
    }
}
