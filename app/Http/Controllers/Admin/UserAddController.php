<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Employes;
use Illuminate\Support\Facades\Hash;

class UserAddController extends Controller
{
    function user_add()
    {
        return view('admin.add_user.add_users');
    }
    function user_view()
    {

        $view_Add = Employes::orderBy('id', 'desc')->get();
        return view('admin.add_user.view_user', compact('view_Add'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required',
            'dob' => 'required|date',
            'gender' => 'required',
        ]);


        $employee = new Employes();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->gender = $request->gender;
        $employee->dob = $request->dob;
        $employee->city = $request->city;
        $employee->state = $request->state;
        $employee->country = $request->country;
        $employee->address = $request->address;
        $employee->sallery = $request->sallery;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('storage/admin/form/profile_image/'), $filename);
            $employee->profile_image = $filename;
        }




        if ($employee->save()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->employee_id = $employee->id;
            $user->save();

            return redirect()->route('user.view')->with('success', 'User & Employee created successfully!');
        } else {
            return redirect()->back()->with('error', 'Error saving employee');
        }
    }

    public function user_update(Request $request)
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
        $employee->sallery = $request->sallery;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('storage/admin/form/profile_image/'), $filename);
            $employee->profile_image = $filename;
        }

        if ($employee->update()) {
            $user = User::where('employee_id', $request->id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->update();

            return back()->with('success', 'User & Employee updated successfully!');
        } else {
            return back()->with('error', 'Error saving employee');
        }
    }



    function del_view($id)
    {
        $del = Employes::find($id);
        if ($del->delete()) {
            return back()->with('success', 'Data delete successfully');
        } else {
            return back()->with('error', 'Error');
        }
    }
}
