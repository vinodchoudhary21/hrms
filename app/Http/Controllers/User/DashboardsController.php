<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holidays;
use App\Models\Tasks;
use App\Models\Attendance;
use App\Models\Employes;
use App\Models\Leaves;
use App\Models\User;
use Carbon\Carbon;

class DashboardsController extends Controller
{
    function mains_user()
    {
        $user_id = auth()->id();
        $user = User::find($user_id);
        $employee = Employes::where('id', $user->employee_id)->first();
        $todayDate = Carbon::now()->format('d - F - Y');
        $endDate = Carbon::now()->addMonth(1);
        $attend = Attendance::where('user_id', $employee->id)->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->orderBy('id', 'desc')->get();
        $holidays = Holidays::whereDate('holiday_date', '>=', $todayDate)->whereDate('holiday_date', '<=', $endDate)->where('status','active')->orderBy('id', 'desc')->get();

        $Tasksh = Tasks::with('user', 'project')->whereDate('created_at', Carbon::now()->toDateString())->orderBy('id', 'desc')->get();



        $thismonthAttendance = Attendance::where('user_id', $employee->id)->whereMonth('created_at', now()->month)->whereyear('created_at', now()->year)->count();
        $thismonthLeaves = Leaves::where('user_id', $employee->id)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();


        $birthdays = Employes::where('id', $user->employee_id)->get();
        return view('user.dashboard.dashboard', compact('Tasksh', 'holidays', 'attend', 'todayDate', 'attend', 'Tasksh', 'thismonthAttendance', 'thismonthLeaves', 'birthdays'));
    }
}
