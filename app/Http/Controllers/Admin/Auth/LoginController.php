<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use ResponseTrait;

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
            'role' => 'admin'
        ];
       
        $remember = $request->has('remember') ? true : false;
        if (Auth::guard('admin')->attempt($credentials,$remember)) {
            
            $user = Auth::guard('admin')->user();
            return redirect()->route('admin.dashboard');
        }
        $redirect = route('admin.login');
        return $this->error($redirect, 'The provided credentials do not match our records.');

    }

    public function logout(){
        Session::flush();
        Auth::guard('admin')->logout();         
        return Redirect('admin/login');
    }
}
