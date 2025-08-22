<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Employes;
use Illuminate\Http\Request;
use App\Models\Leaves;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Notifications;
use App\Models\AdminNotifications;

class UserLeavesController extends Controller
{
    function user_leaves()
    {

        $user_id = auth()->id();
        $user = User::find($user_id);
        $employee = Employes::where('id', $user->employee_id)->first();
        $leaves = Leaves::where('user_id', $employee->id)->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->orderBy('id', 'desc')->get();
        $notifitions =  AdminNotifications::where('type', 'leave')->where('is_read', false)->update(['is_read' => true]);

        return view('user.user_leaves.user_leaves', compact('leaves'));
    }
    function user_addleaves()
    {
        return view('user.user_leaves.add_leaves');
    }


    public function leaves_store(Request $req)
    {
        $send = new Leaves();
        $send->user_id = auth()->id();
        $send->leave_type_id = $req->leave_type_id;
        $send->start_at = $req->start_at;
        $send->end_at = $req->end_at;
        $send->reason = $req->reason;
        $send->status = $req->status ?? 'pending';

        if ($send->save()) {
            $notification = new Notifications();
            $notification->user_id = auth()->id();
            $notification->type = 'leave';
            $notification->message = $req->reason;
            $notification->is_read = false;
            $notification->save();

            return redirect()->route('user.leaves')->with('success', 'Leave applied successfully!');
        } else {
            return redirect()->back()->with('error', 'Error applying for leave.');
        }
    }



    function leaves_delect($id)
    {
        $del = Leaves::find($id);
        if ($del->delete()) {
            return back()->with('success', 'Data delete successfully');
        } else {
            return back()->with('error', 'Error');
        }
    }
}
