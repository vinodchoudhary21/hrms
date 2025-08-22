<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotifications;
use App\Models\Notifications;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Project;
use App\Models\Tasks;
use Carbon\Carbon;

class TasksController extends Controller
{
    function admin_tasks()
    {
        $notifiction = Notifications::where('type', 'tasks')->where('is_read', false)->update(['is_read' => true]);
        $Tasksh = Tasks::with('user', 'project')->orderBy('id', 'desc')->get();
        return view('admin.tasks.tasks', compact('Tasksh'));
    }

    function admin_addtasks()
    {
        $users = User::all();
        $projectsh = Project::get();
        return view('admin.tasks.add_task', compact('users', 'projectsh'));
    }






    public function tasks_store(Request $req)
    {
        $send = new Tasks();
        $send->project_id = $req->project_id;
        $send->user_id = $req->user_id;
        $send->task_name = $req['task_name'];
        $send->start_time = $req['start_time'];
        $send->end_time = $req['end_time'];
        $send->status = $req->input('status', 'pending');

        if ($send->save()) {
            $task = new AdminNotifications();
            $task->user_id = $req->user_id;
            $task->name = $req->task_name;
            $task->type = 'tasks';
            $task->is_read = false;
            $task->save();


            return redirect()->route('admin.tasks')->with('success', 'Data Sent Successfully');
        } else {
            return back()->with('error', 'Error while saving');
        }
    }



    public function tasks_update(Request $request)
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


        $tasks = new AdminNotifications();
        $tasks->user_id =  $task->user_id ?? $request->user_id;
        $tasks->type = 'tasks';
        $tasks->message = "Your Tasks request has been " . strtoupper($request->status);
        $tasks->is_read = false;
        $tasks->save();



        return back()->with('success', 'Task updated successfully');
    }




    function tasks_delect($id)
    {
        $del = Tasks::find($id);
        if ($del->delete()) {
            return back()->with('success', 'Data delete successfully');
        } else {
            return back()->with('error', 'Error');
        }
    }
}
