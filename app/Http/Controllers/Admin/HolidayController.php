<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotifications;
use Illuminate\Http\Request;
use App\Models\Holidays;
use App\Models\Notifications;
use Carbon\Carbon;


class HolidayController extends Controller
{
    function admin_holiday()
    {
        // $today  = Carbon::now();
        // $nextMonth  = Carbon::now()->addMonth();

        // $holidays = Holidays::whereDate('holiday_date', '>=', $today)
        //     ->whereDate('holiday_date', '<=', $nextMonth)
        //     ->orderBy('id', 'desc')
        //     ->get();
        $holidays = Holidays::orderBy('id', 'desc')
            ->get();

        return view('admin.holiday.holiday', compact('holidays'));
    }
    function add_holiday()
    {
        return view('admin.holiday.add_holiday');
    }


    public function holiday_store(Request $req)
    {
        $req->validate([
            'holiday_name' => 'required|string|max:255',
            'holiday_date' => 'required|date',
            'description' => 'nullable|string',
        ]);


        $send = new Holidays();
        $send->holiday_name = $req['holiday_name'];
        $send->holiday_date = $req['holiday_date'];
        $send->description = $req['description'];
        $send->status = $req['status'];



        if ($send->save()) {
            $holi = new AdminNotifications();
            $holi->user_id = auth()->guard('web')->id();
            $holi->type = 'holidays';
            $holi->name = $req->holiday_name;
            $holi->is_read = false;
            $holi->message = $req->description;
            $holi->save();



            return redirect()->route('admin.holiday')->with('success', 'Data Sent Successfully');
        } else {
            return back()->with('error', 'error');
        }
    }


    public function holiday_update(Request $req, $id)
    {


        $holiday = Holidays::findOrFail($id);
        $holiday->holiday_name = $req->holiday_name;
        $holiday->holiday_date = $req->holiday_date;
        $holiday->description = $req->description;
        $holiday->status = $req->status;
        $holiday->save();

        return redirect()->route('admin.holiday')->with('success', 'Holiday updated successfully.');
    }


    // Controller
    public function holiday_delect($id)
    {
        $del = Holidays::find($id);
        if ($del && $del->delete()) {
            return back()->with('success', 'Data deleted successfully');
        } else {
            return back()->with('error', 'Error deleting data');
        }
    }
}
