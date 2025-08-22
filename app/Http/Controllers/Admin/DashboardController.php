<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holidays;
use App\Models\Tasks;
use Carbon\Carbon;
use App\Models\Employes;
use App\Models\User;
use App\Models\Leaves;



class DashboardController extends Controller
{
    public function Admin_Stor()
    {
        $today = Carbon::today();
        $next30 = Carbon::today()->addDays(30);

        $today_md = $today->format('m-d');
        $next30_md = $next30->format('m-d');

        $birthdays = Employes::whereRaw("DATE_FORMAT(dob, '%m-%d') >= ?", [$today_md])
            ->whereRaw("DATE_FORMAT(dob, '%m-%d') <= ?", [$next30_md])
            ->orderByRaw("DATE_FORMAT(dob, '%m-%d') ASC")
            ->get();

        $holidays = Holidays::whereDate('holiday_date', '>=', $today)
            ->whereDate('holiday_date', '<=', $next30)
            ->orderBy('id', 'desc')
            ->get();

        $leaves = Leaves::whereDate('start_at', '>=', $today)
            ->whereDate('end_at', '<=', $next30)
            ->orderBy('id', 'desc')
            ->get();




        return view('admin.dashboard.dashboard', compact('holidays', 'birthdays', 'leaves'));
    }
}
