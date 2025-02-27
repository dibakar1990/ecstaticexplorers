<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        if(Auth::guard('admin')->check()){
            return redirect()->route('admin.dashboard.index');
        }

        return view('admin.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email',$request->email)->where('role','admin')->first();
        if($user){
            $token = encrypt($user->id);
            $reset = DB::table('password_reset_tokens')->where('email',$user->email)->first();
            if($reset){
                $query = DB::table('password_reset_tokens')->where('email', $user->email)
                                    ->update([
                                        'token' => $token,
                                        'created_at' => Carbon::now()
                                    ]);
            }else{
                $values = array('token' => $token,'email' => $request->email,'created_at' => Carbon::now());
                DB::table('password_reset_tokens')->insert($values);
              
            }
            $setting = Setting::find(1);
            $request_sent = [
                'file_path' => $setting->file_path,
                'file_url' => $setting->file_path_url,
                'token' => $token,
                'name' => $user->name,
                'email' => $user->email,
                'reset_link' => route('admin.password.reset',['token' => $token])
            ];
            Mail::to($user->email)->send(new ForgotPasswordMail($request_sent));

            return redirect()->back()->with('success', "we have send the reset password link to your register email address");

        }else{
            return redirect()->back()->with('error', "This email is not a admin");
        }
    }
}
