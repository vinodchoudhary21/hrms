<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotifications;
use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Models\Work_home;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;

class WorkFormHomeController extends Controller
{
    function admin_work()
    {
        $works = Work_home::whereDate('work_date', Carbon::now()->today())->orderBy('id', 'desc')->get();
        $notifictions = AdminNotifications::where('type', 'tasks')->where('is_read', false)->update(['is_read' => true]);

        $notifiction = Notifications::where('type', 'work_forms')->where('is_read', false)->update(['is_read' => true]);
        return view('admin.work_home.work_home', compact('works'));
    }
    function admin_addwork()
    {
        $users = User::all();
        return view('admin.work_home.admin_addwork', compact('users'));
    }



    public function addwork_store(Request $req)
    {
        $send = new Work_home();
        $send->user_id = $req->user_id;
        $send->work_date = $req['work_date'];
        $send->start_time = $req['start_time'];
        $send->end_time = $req['end_time'];
        $send->reason = $req['reason'];
        $send->location = $req['location'];
        $send->status = $req->input('status', 'pending');


        if ($send->save()) {
            $work = new AdminNotifications();
            $work->user_id = $req->user_id;
            $work->name = $req->reason;
            $work->type = 'works';
            $work->message = $req->location;
            $work->is_read = false;
            $work->save();

            return redirect()->route('admin.work.home')->with('success', 'Data Sent Successfully');
        } else {
            return back()->with('error', 'Error while saving');
        }
    }



    function workadd_delect($id)
    {
        $del = Work_home::find($id);
        if ($del->delete()) {
            return back()->with('success', 'Data delete successfully');
        } else {
            return back()->with('error', 'Error');
        }
    }



    public function work_update(Request $request)
    {


        if ($request->filled('ids')) {

            $request->validate([
                'statuses' => 'required|array',
                'statuses.*' => 'in:pending,accept,reject',
                'ids' => 'required|array',
            ]);

            foreach ($request->ids as $index => $id) {
                $status = $request->statuses[$index];
                $works =  Work_home::find($id);

                if ($works) {
                    $works->status = $status;
                    $works->save();

                    $work_home = new AdminNotifications();
                    $work_home->user_id = $works->user_id;
                    $work_home->type = 'work_forms';
                    $work_home->message = "Your Work Form Home request has been " . strtoupper($request->status);
                    $work_home->is_read = false;
                    $work_home->save();
                }
            }
        }

        if ($request->filled('id')) {
            $task = Work_home::find($request->id);

            if ($task) {
                $task->status = $request->status;
                $task->save();


                $work_home = new AdminNotifications();
                $work_home->user_id =  $task->user_id;
                $work_home->type = 'work_forms';
                $work_home->message = "Your Work Form Home request has been " . strtoupper($request->status);
                $work_home->is_read = false;
                $work_home->save();
            }
        }

        return back()->with('success', 'Leave status updated successfully');
    }
}
