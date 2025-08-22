<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admins;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    function login_add()
    {
        return view('admin.login.login');
    }


    public function login_admin_Send(Request $req)
    {
        $credentials = $req->only('email', 'password');

        if (Auth::guard('Admins')->attempt($credentials)) {
            $Admins = Auth::guard('Admins')->user();

            $req->session()->put('ADMIN', $Admins->email);
            $req->session()->put('ADMINUSERID', $Admins->id);


            return redirect()->route('mains_admin')->with('success', 'Welcome To Admin');
            
        } else {
            return back()->with('error', 'Login details are not valid');
        }
    }


    function adminlogout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login.add')->with('error', 'Logout Successfull');
    }
}
