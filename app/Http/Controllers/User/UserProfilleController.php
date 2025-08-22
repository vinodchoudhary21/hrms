<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Employes;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserProfilleController extends Controller
{
    function user_profile()
    {
         $user = auth()->user();
         $profile = Employes::where('id', $user->employee_id)->first();
        return view('user.profile.user_profile', compact('profile'));
    }








    public function profile_update(Request $request)
    {
     $employee = Employes::find($request->id);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->gender = $request->gender;
        $employee->dob = $request->dob;
        $employee->city = $request->city;
        $employee->state = $request->state;
        $employee->country = $request->country;
        $employee->address = $request->address;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('storage/admin/form/profile_image/'), $filename);
            $employee->profile_image = $filename;
        }

        if ($employee->update()) {
            $user = User::where('employee_id',$request->id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->employee_id = $employee->id;
            $user->update();

            return back()->with('success', 'User & Employee created successfully!');
        } else {
            return back()->with('error', 'Error saving employee');
        }
    }
}
