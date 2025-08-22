<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserInternshipController extends Controller
{
    public function internship_user()
    {
        return view('user.Internship_user.Internship_user');
    }
}
