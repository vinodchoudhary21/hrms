<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminPasswordController extends Controller
{
    function admin_password()
    {
        $admin = auth()->guard('Admins')->user();
        $change_password = Admins::where('id', $admin->id)->first();
        return view('admin.password.change_password', compact('change_password'));
    }



  
    public function admin_changepass(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|max:15',
            'new_password' => 'required|min:6|max:15|same:conform_password',
            'conform_password' => 'required|min:6|max:15',
        ]);
        $admin = auth()->guard('Admins')->user();
        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Wrong current password');
        }
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', 'Password updated successfully');
    }
}
