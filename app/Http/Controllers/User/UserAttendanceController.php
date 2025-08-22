<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserAttendanceController extends Controller
{

    public function attendance_user(Request $request)
    {
        $user_id = auth()->id();
        $user = User::find($user_id);
        $employee = Employes::where('id', $user->employee_id)->first();

        $query = Attendance::where('user_id', $employee->id);

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        }

        $attend = $query->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->orderBy('id', 'desc')->get();

        $attendance = Attendance::where('user_id', $employee->id)
            ->whereDate('date', today())
            ->whereNull('check_out')
            ->first();

        $hasAttendance = $attendance ? 1 : 0;

        $todayDate = Carbon::now()->format('d - F - y');

        return view('user.attendance_user.attendance_user', compact('todayDate', 'attend', 'hasAttendance'));
    }




    public function attendance(Request $req)
    {
        $now = Carbon::now();
        $user_id = auth()->id();
        $user = User::find($user_id);
        $employee = Employes::find($user->employee_id);

        // Check if attendance already marked today
        $attendanceCount = Attendance::where('user_id', $employee->id)
            ->whereDate('date', today())
            ->count();

        if ($attendanceCount < 3) {
            // Save attendance
            $attendance = new Attendance();
            $attendance->user_id = $employee->id;
            $attendance->date = $now->toDateString();
            $attendance->check_in = $now->toTimeString();
            $attendance->save();

            // ✅ Monthly Paid Leave Logic
            $currentMonth = $now->format('Y-m');
            $lastLeaveGiven = $employee->leave_updated_at;

            if (!$lastLeaveGiven || Carbon::parse($lastLeaveGiven)->format('Y-m') !== $currentMonth) {
                $employee->leave += 1;
                $employee->leave_updated_at = $now;
                $employee->save();
            }

            return back()->with('success', 'Check-In successful & Paid Leave Updated!');
        }

        return back()->with('error', 'Already checked in 3 times today!');
    }

    public function check_out(Request $req)
    {
        $today = Carbon::today();

        $user_id = auth()->id();
        $user = User::find($user_id);
        $employee = Employes::where('id', $user->employee_id)->first();
        $attendance = Attendance::where('user_id', $employee->id)->whereDate('date', today())->whereNull('check_out')->latest()->first();
        if ($attendance) {
            $attendance->check_out = now();
            $attendance->working_hours = Carbon::parse($attendance->check_in)->diff(now())->format('%H:%I:%S');


            $monthly_sallery = floatval($employee->sallery);
            $daily_sallery = $monthly_sallery / Carbon::now()->daysInMonth;
            $hourly_salary  = $daily_sallery / 7;
            $minit_sallery = $hourly_salary / 60;
            $second_salary = $minit_sallery / 60;


            $checkIn = Carbon::parse($attendance->check_in);
            $checkOut = now();
            $workingSeconds = $checkIn->diffInSeconds($checkOut);

            $total_sallery = $workingSeconds * $second_salary;

            $attendance->working_hours = gmdate("H:i:s", $workingSeconds);
            $attendance->earning_salary = round($total_sallery, 2);
            $attendance->save();


            return back()->with('success', 'Checked-Out Successfully!');
        }
        return back()->with('error', 'Check-In not found or already Checked-Out');
    }
}
