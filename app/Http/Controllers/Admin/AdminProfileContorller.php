<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Http\Request;

class AdminProfileContorller extends Controller
{
    function admin_profile()
    {
        $admin = auth()->guard('Admins')->user();
        $admin_profile = Admins::where('id', $admin->id)->first();
        return view('admin.admin_profile.admin_profile', compact('admin_profile'));
    }

    function profile_updates(Request $req)
    {
        $send = Admins::find($req->id);
        $send->name = $req['name'];
        $send->email = $req['email'];
        $send->phone = $req['phone'];


        if ($send->save()) {
            return redirect()->route('admin.profile')->with('success', 'Data Sent Successfully');
        } else {
            return back()->with('error', 'error');
        }
    }
}
