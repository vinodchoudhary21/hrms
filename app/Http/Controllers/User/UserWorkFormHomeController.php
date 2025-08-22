<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminNotifications;
use App\Models\Employes;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Work_home;
use App\Models\Notifications;

class UserWorkFormHomeController extends Controller
{
    function work_form()
    {
        $user_id = auth()->id();
        $user = User::find($user_id);
        $employee = Employes::where('id', $user->employee_id)->first();
        $work = Work_home::where('user_id', $employee->id)->orderBy('id', 'desc')->get();


        $notifition = AdminNotifications::where('user_id', auth()->id())->whereIn('type', ['works', 'work_forms'])->where('is_read', false)->update(['is_read' => true]);
        return view('user.work_form_home.work_form_home', compact('work'));
    }

    function add_work()
    {
        return view('user.work_form_home.add_work');
    }





    public function work_store(Request $req)
    {
        $send = new Work_home();
        $send->user_id = auth()->user()->id;
        $send->work_date = $req['work_date'];
        $send->start_time = $req['start_time'];
        $send->end_time = $req['end_time'];
        $send->reason = $req['reason'];
        $send->location = $req['location'];
        $send->status = $req['status'];


        if ($send->save()) {
            $work_home = new Notifications();
            $work_home->user_id = auth()->user()->id;
            $work_home->type = 'work_forms';
            $work_home->message = $req->reason;
            $work_home->is_read = false;
            $work_home->save();

            return redirect()->route('work_home.user')->with('success', 'Data Sent Successfully');
        } else {
            return back()->with('error', 'Error while saving');
        }
    }


    function work_delect($id)
    {
        $del = Work_home::find($id);
        if ($del->delete()) {
            return back()->with('success', 'Data delete successfully');
        } else {
            return back()->with('error', 'Error');
        }
    }
}
