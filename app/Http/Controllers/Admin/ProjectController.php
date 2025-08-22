<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    function admin_project()
    {
        $project = Project::orderBy('id', 'desc')->get();
        return view('admin.project.project', compact('project'));
    }

    function admin_addproject()
    {
        return view('admin.project.add_project');
    }





    public function project_store(Request $req)
    {
        $send = new Project();
        $send->project_name = $req['project_name'];
        $send->client_name = $req['client_name'];
        $send->start_time = $req['start_time'];
        $send->end_time = $req['end_time'];
        $send->project_remark = $req['project_remark'];
        $send->status = $req->input('status', 'pending');
        $send->save();

        if ($send) {
            return redirect()->route('admin.project')->with('success', 'Data Sent Successfully');
        } else {
            return back()->with('error', 'Error while saving');
        }
    }

    public function project_update(Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,accept,reject',
        ]);

        if ($request->filled('ids')) {
            $ids = explode(',', $request->ids);
            $projects = Project::whereIn('id', $ids)->get();

            foreach ($projects as $project) {
                $project->status = $request->status;
                $project->save();
            }
        }


        if ($request->filled('id')) {

            $project = Project::find($request->id);

            $project->status = $request->status;
            $project->save();
        }



        return back()->with('success', 'Leave status updated successfully');
    }




    function project_delect($id)
    {
        $del = Project::find($id);
        if ($del->delete()) {
            return back()->with('success', 'Data delete successfully');
        } else {
            return back()->with('error', 'Error');
        }
    }
}
