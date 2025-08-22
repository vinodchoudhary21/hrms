<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leaves;
use Carbon\Carbon;
use App\Models\Notifications;
use App\Models\AdminNotifications;


class LeavesController extends Controller
{
    function admin_leaves()
    {

        $leaves = Leaves::orderBy('id', 'desc')
            ->get();
        $notifitions =  Notifications::where('type', 'leave')->where('is_read', false)->update(['is_read' => true]);
        return view('admin.leaves.leaves', compact('leaves'));
    }



    public function admin_leaves_delect($id)
    {
        $del = Leaves::find($id);
        if ($del && $del->delete()) {
            return back()->with('success', 'Data deleted successfully');
        } else {
            return back()->with('error', 'Error deleting data');
        }
    }


    // public function leaves_update(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:leaves,id',
    //         'status' => 'required|in:pending,accept,reject',
    //     ]);

    //     $leave = Leaves::find($request->id);
    //     $leave->status = $request->status;
    //     $leave->update();

    //     $notify = new AdminNotifications();
    //     $notify->user_id = $leave->user_id; // ✅ Fix: pull from leave
    //     $notify->type = 'leave';
    //     $notify->message = "Your leave request has been " . strtoupper($request->status);
    //     $notify->is_read = false;
    //     $notify->save();

    //     return back()->with('success', 'Leave status updated and user notified!');
    // }





    public function leaves_update(Request $request)
    {
        if ($request->filled('ids')) {
            $request->validate([
                'statuses' => 'required|array',
                'statuses.*' => 'in:pending,accept,reject',
                'ids' => 'required|array',
            ]);

            foreach ($request->ids as $index => $id) {
                $status = $request->statuses[$index];

                $leave = Leaves::find($id);
                if ($leave) {
                    $leave->status = $status;
                    $leave->save();

                    $notify = new AdminNotifications();
                    $notify->user_id = $leave->user_id;
                    $notify->type = 'leave';
                    $notify->message = "Your leave request has been " . strtoupper($status);
                    $notify->is_read = false;
                    $notify->save();
                }
            }
        }

        if ($request->filled('id') && $request->has('status')) {
            $request->validate([
                'status' => 'required|in:pending,accept,reject',
            ]);

            $leave = Leaves::find($request->id);
            if ($leave) {
                $leave->status = $request->status;
                $leave->save();

                $notify = new AdminNotifications();
                $notify->user_id = $leave->user_id;
                $notify->type = 'leave';
                $notify->message = "Your leave request has been " . strtoupper($request->status);
                $notify->is_read = false;
                $notify->save();
            }
        }

        return back()->with('success', 'Leave status updated and user notified!');
    }
}
