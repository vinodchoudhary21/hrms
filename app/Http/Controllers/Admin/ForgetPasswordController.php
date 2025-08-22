<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admins;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;

class ForgetPasswordController extends Controller
{
    function forget_password()
    {
        return view('admin.forget_password.forget_password');
    }





    public function verify(Request $request)
    {
        $key = mt_rand(100000, 999999);
        $details = [
            'title' => 'Mail From Forget Password',
            'body' =>   $key
        ];
        $data = $request->input();
        $key_expire = date("Y-m-d H:i:s", strtotime("+30 minutes"));
        $result = Admins::where('email', $data['email'], $key_expire)->get()->first();
        // dd($result);
        if ($result) {
            if ($data['email'] == $result->email) {
                $add_info = Admins::where('email', $result->email)->get()->first();
                $add_info->email = $request->input('email');
                $add_info->otp = $key;
                session()->put('verify_email', $add_info->email);
                $add_info->update();
                Mail::to($request->input('email'))->send(new MyTestMail($details));
                return redirect()->back()->with('success', 'OTP Sent Successfully');;
            } else {
                return back()->with('error', 'Unverified Email');
            }
        } else {
            return back()->with('error', 'Unverified Email');
        }
    }



    public function check_otp(Request $request)
    {
        $request->validate([
            'otp' => 'required|min:6|max:6',
        ]);
        $data = $request->input();
        // dd($data);
        $email = session()->get('verify_email');
        $result = Admins::where('otp', $data['otp'])->where('email', $email)->get()->first();
        if ($result) {
            if ($data['otp'] == $result->otp) {
                session()->put('forget_otp', $result->otp);
                return back()->with('success', 'OTP Verified Successfully');
            } else {
                return back()->with('success', 'Enter A Valid OTP');
            }
        } else {
            return back()->with('error', 'Enter A Valid OTP');
        }
    }


    public function new_pass(Request $request)
    {
        // $validatedData = $request->validate([
        //     'password' => 'required|min:6|max:15|same:conform_password	',
        //     'conform_password	' => 'required|min:6|max:15'
        // ]);
        if ($email = session()->get('verify_email')) {
            $edit_pass = Admins::where('email', $email)->get()->first();
            $edit_pass->password = Hash::make($request['password']);
            // $edit_pass->conform_password     = $request['conform_password	'];
            if ($edit_pass->update()) {
                session()->flash('verify_email');
                session()->flash('forget_otp');
                return redirect()->route('login.add')->with('success', 'Password Updated Successfully');
            } else {
                return back()->with('error', 'error');
            }
        } else {
            return back()->with('error', 'error');
        }
    }
}
