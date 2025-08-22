<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserSallery;
use App\Models\AdminNotifications;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Employes;
use App\Models\Holidays;
use App\Models\Sellary;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use App\Models\Leaves;
use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class SellaryController extends Controller
{
    function sallerys()
    {
        $sellarys = Sellary::orderBy('id', 'desc')->get();
        return view('admin.sellary.sellary', compact('sellarys'));
    }
    function add_sallerys()
    {
        $user = User::all();
        return view('admin.sellary.add_sallery', compact('user'));
    }


    
    public function add_storesallerys(Request $req)
    {
        $checkDb = Sellary::where('user_id', $req->user_id)->where('month', $req->month)->exists();
        if ($checkDb) {
            return redirect()->back()->with('error', 'Is user ke liye is mahine ka salary data already saved hai.');
        }

        $send = new Sellary();
        $send->month = $req['month'];
        $send->user_id = $req->user_id;
        $employee = Employes::where('id', $req->user_id)->first();

        $sallery = $employee->sallery;
        $total_days = Carbon::parse($req['month'])->daysInMonth;
        $perdaySalary =  $sallery / $total_days;

        $startDate = Carbon::parse($req->month)->startOfMonth();
        $endDate = Carbon::parse($req->month)->endOfMonth();

        $total_earning_salary = Attendance::where('user_id', $req->user_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('earning_salary');

        $dates = collect(CarbonPeriod::create($startDate, $endDate));

        $sundays = $dates->filter(fn($date) => $date->isSunday())->count();

        $saturdays = $dates->filter(fn($date) => $date->isSaturday())->values();
        $oddSaturdays = $saturdays->filter(function ($date, $index) {
            return ($index + 1) % 2 !== 0; // odd index (1st, 3rd, 5th)
        })->count();
        $weekoff = $sundays + $oddSaturdays;
        $weekoffsalary  = $perdaySalary * $weekoff;
        $totalsalary = $total_earning_salary + $weekoffsalary;

        $allLeaves = Leaves::where('user_id', $req->user_id)
            ->where('status', 'accept')
            ->whereDate('start_at', '>=', $startDate)
            ->whereDate('start_at', '<=', $endDate)
            ->orderBy('start_at')
            ->get();

        $totalLeaves = $allLeaves->count();

        $unpaidLeaves = max(0, $totalLeaves - min($employee->leave, $totalLeaves));

        $leavesSellery = $unpaidLeaves * $perdaySalary;
        $AllleavesSellery = $totalsalary - $leavesSellery;

        $holidays = Holidays::where('status', 'active')
            ->whereDate('holiday_date', '>=', $startDate)
            ->whereDate('holiday_date', '<=', $endDate)
            ->orderBy('holiday_date')
            ->get();

        $filteredHolidays = $holidays->filter(function ($holiday) {
            $date = Carbon::parse($holiday->holiday_date);
            $dayOfWeek = $date->dayOfWeek;

            if ($dayOfWeek === 0) {
                return false;
            }

            if ($dayOfWeek === 6) {
                $weekOfMonth = ceil($date->day / 7);
                if (in_array($weekOfMonth, [1, 3, 5])) {
                    return false;
                }
            }

            return true;
        });

        $holidays_count = $filteredHolidays->count();
        $holidays_sallery =  $holidays_count * $perdaySalary;
        $totalsallerysholidays = $holidays_sallery + $totalsalary;
        $send->earned_salary = $totalsallerysholidays;

        if ($send->save()) {
            // Admin Notifications save करें
            $sellary = new AdminNotifications();
            $sellary->user_id = $req->user_id;
            $sellary->type = 'sellery';
            $sellary->is_read = false;
            $sellary->name = 'Download Sellary Slip';
            $sellary->message = 'Congratulations';
            $sellary->save();

            // Email भेजें
            Mail::to($employee->email)->send(new UserSallery($employee, $req->month));
        }

        return redirect()->route('admin.sallery')->with('success', 'Salary saved and email sent successfully.');
    }






















    public function generatePdf($id)
    {
        $salary = Sellary::findOrFail($id);
        $employee = Employes::findOrFail($salary->user_id);

        $month = $salary->month;
        $sallery = $employee->sallery;
        $total_days = Carbon::parse($month)->daysInMonth;
        $perdaySalary = $sallery / $total_days;

        $startDate = Carbon::parse($month)->startOfMonth();
        $endDate = Carbon::parse($month)->endOfMonth();

        // Weekoff salary calculation
        $dates = collect(CarbonPeriod::create($startDate, $endDate));
        $sundays = $dates->filter(fn($date) => $date->isSunday())->count();
        $saturdays = $dates->filter(fn($date) => $date->isSaturday())->values();
        $oddSaturdays = $saturdays->filter(fn($date, $index) => ($index + 1) % 2 !== 0)->count();
        $weekoff = $sundays + $oddSaturdays;
        $weekoffSalary = $weekoff * $perdaySalary;
        $total_earning_salary = Attendance::where('user_id', $salary->user_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('earning_salary');
        $workingDaysCount = Attendance::where('user_id', $salary->user_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->distinct('date')
            ->count('date');  // Unique dates par work kiya


        // Leave Adjustment
        $allLeaves = Leaves::where('user_id', $salary->user_id)
            ->where('status', 'accept')
            ->whereDate('start_at', '>=', $startDate)
            ->whereDate('start_at', '<=', $endDate)
            ->get();

        $totalLeaves = $allLeaves->count();
        $unpaidLeaves = max(0, $totalLeaves - min($employee->leave, $totalLeaves));
        $leaveDeduction = $unpaidLeaves * $perdaySalary;

        // Holidays (excluding Sundays and 1st, 3rd, 5th Saturday)
        $holidays = Holidays::where('status', 'active')
            ->whereDate('holiday_date', '>=', $startDate)
            ->whereDate('holiday_date', '<=', $endDate)
            ->get();

        $filteredHolidays = $holidays->filter(function ($holiday) {
            $date = Carbon::parse($holiday->holiday_date);
            if ($date->isSunday()) return false;

            if ($date->isSaturday()) {
                $weekOfMonth = ceil($date->day / 7);
                if (in_array($weekOfMonth, [1, 3, 5])) {
                    return false;
                }
            }

            return true;
        });

        $holidaysCount = $filteredHolidays->count();
        $holidaysSalary = $holidaysCount * $perdaySalary;

        $data = [
            'employee' => $employee,
            'salary' => $salary,
            'month' => Carbon::parse($month)->format('F Y'),
            'total_days' => $total_days,
            'perdaySalary' => $perdaySalary,
            'weekoff' => $weekoff,
            'weekoffSalary' => $weekoffSalary,
            'unpaidLeaves' => $unpaidLeaves,
            'leaveDeduction' => $leaveDeduction,
            'holidaysCount' => $holidaysCount,
            'holidaysSalary' => $holidaysSalary,
            'finalSalary' => $salary->earned_salary,
            'total_earning_salary' => $total_earning_salary,
            'workingDaysCount' => $workingDaysCount,



        ];

        $pdf = Pdf::loadView('pdf.salary_slip', $data);
        return $pdf->download('SalarySlip_' . $employee->name . '_' . $salary->month . '.pdf');
    }












}
