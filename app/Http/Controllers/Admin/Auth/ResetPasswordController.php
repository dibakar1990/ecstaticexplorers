<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        $data = DB::table('password_reset_tokens')->where('token',$token)->first();
        if($data){
            $currentDateTime = Carbon::now();
            $newDateTime = Carbon::parse($data->created_at)->addHours(24);
            if($currentDateTime < $newDateTime){
                return view('admin.auth.passwords.reset',compact('token'));
            }else{
                return redirect()->route('admin.password.request')->with('warning', "token is expired");
            }
        }else{
            return redirect()->route('admin.password.request')->with('warning', "token is expired");
        }
    }

    public function reset(Request $request){
        $token = $request->get('token');
        $id = decrypt($token);
        try {
                $request->validate([
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                ]);

                $checkData = DB::table('password_reset_tokens')->where('token',$token)->count();
                if($checkData > 0){
                    $user = User::find($id);
                    $user->password = $request->password;
                    $user->save();

                    DB::table('password_reset_tokens')->where('token',$token)->delete();
                    return redirect()->route('admin.login')->with('success', "Password has been changed successfully");
                }else{
                    return redirect()->route('admin.login')->with('warning', "invalid Url Link");
                }

        } catch (DecryptException $e) {
            return redirect()->route('admin.login')->with('warning', "invalid Url Link");
        }
    }
}
