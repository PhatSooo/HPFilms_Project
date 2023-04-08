<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Verify_Email;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class EmailController extends Controller
{
    public function verify_email($isSent = false){
        $token = Str::random(64);
        $mail = 'Email Verification Mail';
        $user = User::find(session()->get('userId'));
        if(Verify_Email::find($user->email) || $isSent == true) {
            Verify_Email::where('email',$user->email)->update(['token' => $token]);
            $mail = 'Resend Email Verification Mail';
        }
        else {
            $verify = new Verify_Email();
            $verify->email = $user->email;
            $verify->token = $token;
            $verify->save();
        }

        Mail::send('pages.user.verify',['token' => $token], function($message) use($user,$mail) {
            $message->to($user->email);
            $message->subject($mail);
        });
        return back()->with('verify_email','We has sent '.$mail.' to your email');
    }

    public function verify_email_request($token){
        $verifyUser = Verify_Email::where('token', $token)->first();
        if($verifyUser){
            DB::table('users')
                ->where('email','=',$verifyUser->email)
                ->update(['email_verified_at' => Carbon::parse(date('Y-m-d H:i:s'))]);
            $user = DB::select('select id from users where email = ?',[$verifyUser->email]);
            return redirect('user/'.$user[0]->id.'/profile');
        }
    }
}
