<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminNotifications;
use App\Models\Attendance;
use App\Models\Employes;
use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Notifications;

class UserTaskController extends Controller
{
    function user_task()
    {
        $today = Carbon::now();
        $last_day = Carbon::now()->addMonth();
        $user_id = auth()->id();
        $user = User::find($user_id);
        $employee = Employes::where('id', $user->employee_id)->first();
        $Tasksh = Tasks::with('user', 'project')->where('user_id', $employee->id)->whereDate('start_time', '>=', $today)->whereDate('end_time', '<=', $last_day)->orderBy('id', 'desc')->get();
        $notifiction = AdminNotifications::where('user_id', auth()->id())
            ->where('type', 'tasks')
            ->where('is_read', false)
            ->update(['is_read' => true]);



        return view('user.user_task.user_task', compact('Tasksh'));
    }

    function tasksuser_delect($id)
    {
        $del = Tasks::find($id);
        if ($del->delete()) {
            return back()->with('success', 'Data delete successfully');
        } else {
            return back()->with('error', 'Error');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tasks,id',
            'task_name' => 'required|string',
            'status' => 'required|in:pending,In Processing,Completed',
        ]);

        $task = Tasks::find($request->id);

        $task->task_name = $request->task_name;
        $task->status = $request->status;
        $task->update();


        $tasks = new Notifications();
        $tasks->user_id = auth()->user()->id;
        $tasks->type = 'tasks';
        $tasks->message = "Your Tasks request has been " . strtoupper($request->status);
        $tasks->is_read = false;
        $tasks->save();



        return back()->with('success', 'Task updated successfully');
    }
}
