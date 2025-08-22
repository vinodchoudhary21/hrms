<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // public function admin_attendance()
    // {

    //     $attend = Attendance::orderBy('id', 'desc')->get();
    //     $employes = User::all();
    //     return view('admin.attendance.attendance', compact('attend', 'employes'));
    // }




    public function admin_attendance(Request $request)
    {
        $query = Attendance::query();


        if ($request->employee_id) {
            $query->where('user_id', $request->employee_id);
        }

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        }


        $attend = $query->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->orderBy('id', 'desc')->get();
        $employes = User::all();

        return view('admin.attendance.attendance', compact('attend', 'employes'));
    }
}
