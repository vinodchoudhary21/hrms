<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoAttendanceClose extends Command
{
    protected $signature = 'attendance:auto-close';
    protected $description = 'Auto-checkout users and mark absentees daily';

    public function handle()
    {
        $today = Carbon::today();
        $users = User::all();

        foreach ($users as $user) {
            $employee = Employes::where('id', $user->employee_id)->first();
            if (!$employee) continue;

            $attendance = Attendance::where('user_id', $employee->id)
                ->whereDate('date', $today)
                ->first();

            if ($attendance) {
                if ($attendance->check_in && !$attendance->check_out) {
                    $checkOutTime = Carbon::today()->setHour(17)->setMinute(0)->setSecond(0);

                    $checkIn = Carbon::parse($attendance->check_in);
                    $workingSeconds = $checkIn->diffInSeconds($checkOutTime);

                    $monthlySalary = floatval($employee->sallery);
                    $dailySalary = $monthlySalary / Carbon::now()->daysInMonth;
                    $hourlySalary = $dailySalary / 7;
                    $perSecondSalary = $hourlySalary / 3600;
                    $earned = $perSecondSalary * $workingSeconds;

                    $attendance->check_out = $checkOutTime;
                    $attendance->working_hours = gmdate('H:i:s', $workingSeconds);
                    $attendance->earning_salary = round($earned, 2);
                    $attendance->mode = 'Auto';
                    $attendance->save();

                    Log::info('Auto check-out done for user ID: ' . $user->id);
                }
            } else {
                $attendance = new Attendance();
                $attendance->user_id = $employee->id;
                $attendance->date = $today;
                $attendance->check_in = null;
                $attendance->check_out = null;
                $attendance->working_hours = '00:00:00';
                $attendance->earning_salary = 0;
                $attendance->status = 'Absent';
                $attendance->mode = 'Auto';
                $attendance->save();

                Log::info('Marked Absent for user ID: ' . $user->id);
            }
        }

        Log::info('Auto checkout and absent marking done for all users.');
    }
}
