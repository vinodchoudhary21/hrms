<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserLoginController extends Controller
{
    function loginn_user()
    {
        return view('user.login_user.user_loginn');
    }



    public function login_user_Send(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $req->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();

            $req->session()->put('USER_EMAIL', $user->email);
            $req->session()->put('USER_ID', $user->id);

            return redirect()->route('mains_user')->with('success', 'Welcome To Admin');
        } else {
            return back()->with('error', 'Login details are not valid');
        }
    }



    function Userlogout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login.user')->with('error', 'Logout Successfull');
    }
}
