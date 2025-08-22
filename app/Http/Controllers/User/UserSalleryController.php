<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminNotifications;
use App\Models\Employes;
use App\Models\Sellary;
use Illuminate\Http\Request;
use App\Models\User;

class UserSalleryController extends Controller
{
    function user_sallery()
    {
        $user_id = auth()->id();
        $user = User::find($user_id);
        $employee = Employes::where('id', $user->employee_id)->first();
        $sallerysh = Sellary::where('user_id', $employee->id)->get();


        $notifition = AdminNotifications::where('user_id', auth()->id())->where('type', 'sellery')->where('is_read', false)->update(['is_read' => true]);
        return view('user.user_sallery.user_sallery', compact('sallerysh'));
    }
}
