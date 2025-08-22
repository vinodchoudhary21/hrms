<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holidays;
use App\Models\Notifications;
use App\Models\AdminNotifications;
use Carbon\Carbon;



class UserHolidayController extends Controller
{
    function holiday_user()
    {
        $start_date = Carbon::now();
        $end_date = Carbon::now()->addMonth(1);
        $holiday = Holidays::whereDate('holiday_date', '>=', $start_date)->whereDate('holiday_date', '<=', $end_date)->where('status', 'active')->orderBy('id', 'desc')->get();

        $notifiction = AdminNotifications::where('type', 'holidays')->where('is_read', false)->update(['is_read' => true]);

        return view('user.holiday_user.holiday_user', compact('holiday'));
    }




    function holiday_delect($id)
    {
        $del = Holidays::find($id);
        if ($del->delete()) {
            return back()->with('success', 'Data delete successfully');
        } else {
            return back()->with('error', 'Error');
        }
    }
}
