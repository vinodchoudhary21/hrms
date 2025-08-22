<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserPasswordController extends Controller
{
    function user_password()
    {
        $user = auth()->guard('web')->user();
        $password = User::where('id', $user->employee_id)->first();
        return view('user.user_password.user_password', compact('password'));
    }


    public function password_update(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|max:15',
            'new_password' => 'required|min:6|max:15|same:conform_password',
            'conform_password' => 'required|min:6|max:15',
        ]);
        $user = auth()->guard('web')->user();
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Wrong current password');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully');
    }
}
