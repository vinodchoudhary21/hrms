<?php
use App\Models\Admins;
use App\Models\Leaves;
use App\Models\Tasks;
use App\Models\Work_home;
use App\Models\Notifications;

$notification = Notifications::where('is_read', false)->count();

$showLeave = Notifications::where('type', 'leave')->where('is_read', false)->orderBy('id', 'desc')->get();
$showLeaveexists = Notifications::where('type', 'leave')->where('is_read', false)->orderBy('id', 'desc')->exists();

$showWork_home = Notifications::where('type', 'work_forms')->where('is_read', false)->orderBy('id', 'desc')->get();
$showWork_homeexists = Notifications::where('type', 'work_forms')->where('is_read', false)->orderBy('id', 'desc')->exists();

$Taskview = Notifications::where('type', 'tasks')->where('is_read', false)->orderBy('id', 'desc')->get(); // collection (for foreach)
$Taskxists = $Taskview->isNotEmpty();

$hasUnread = \App\Models\Notifications::where('is_read', false)->exists();

$admin = auth()->guard('Admins')->user();
$admin_profile = Admins::where('id', $admin->id)->first();
?>

<style>
    .navbar-logo-container-max {
        display: flex;
        justify-content: space-around;

    }

    #side_bar_main_ul .one_bar:hover {
        background-color: rgb(73, 57, 35);
        /* Beguni color */
        color: white;
        border-radius: 6px;
    }

    #side_bar_main_ul .one_bar:hover a {
        color: white;
    }


    .kk {
        font-size: 20px;
        color: red;

    }

    .ll {
        font-size: 20px;
        color: blue;
    }

    .main_text {
        font-size: 27px;
        font-weight: bold;
        color: white;
        display: inline-block;
        border-bottom: 3px solid rgb(128, 6, 241);
        /* padding-bottom: 2px; */
    }

    .navbar-logo-container-max {
        display: flex;
        justify-content: space-around;

    }

    #side_bar_main_ul .one_bar:hover {
        background-color: #6088f3;
        /* Beguni color */
        color: white;
        border-radius: 6px;
    }

    #side_bar_main_ul .one_bar:hover a {
        color: white;
    }
</style>

<section id="main_container_site">
    <nav id="navbar">

        <div id="main_logo_container" class="navbar-logo-container-max">
            <a href="{{ route('mains_admin') }}">
                <img src="{{ url('/') }}/public/img/hrmsaura.webp" alt="logo_web_site" /></a>
            <a href="{{ route('mains_admin') }}">

                <div class="main_text">
                    <b>Aurateria</b>
                </div>
            </a>
        </div>
        <div id="navbar_side" class="navbar-side-max">
            <span id="hamburger_container">
                <div id="hamburger_logo" onclick="handleHamburger(this)">
                    <i class="fa fa-bars"></i>
                </div>
            </span>



            <style>
                .lis-noti:hover {
                    color: blue !important;
                }
            </style>



            <ul id="profile_notification_container">
                <li id="fa-bell-icon" onclick="handleNotificationBell(this)">
                    <i class="fa fa-bell"></i>

                    <span id="notification_header" class="notification-counter">
                        {{ $notification }}
                    </span>


                </li>
                <div id="notification_pannel" class="display-zero no-class">
                    <ul>

                        <li class="lis-noti">

                            @if ($showLeaveexists)
                                <a href="{{ route('admin.leaves') }}">

                                    <h5>Leave Notificatin</h5>
                            @endif

                            @foreach ($showLeave as $leave)
                                <ul>
                                    <li> {{ $leave->users->name }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($leave->created_at)->format('d M Y, h:i A') }}
                                        <br>
                                        Reason:
                                        {{ $leave->message }}
                                    </li>
                                </ul>
                                <br>
                            @endforeach
                            </a>
                        </li>
                        <li class="lis-noti">

                            @if ($showWork_homeexists)
                                <a href="{{ route('admin.work.home') }}">

                                    <h5>Work Notificatin</h5>
                            @endif
                            @foreach ($showWork_home as $work)
                                <ul>
                                    <li> {{ $work->users->name }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($work->created_at)->format('d M Y, h:i A') }}
                                        <br>
                                        Reason:
                                        {{ $work->message }}
                                    </li>
                                </ul>
                                <br>
                            @endforeach

                            </a>
                        </li>
                        <li class="lis-noti">

                            @if ($Taskxists)
                                <a href="{{ route('admin.tasks') }}">

                                    <h5>Task Notificatin</h5>
                            @endif
                            @foreach ($Taskview as $task)
                                <ul>
                                    <li> {{ $task->users->name }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($task->created_at)->format('d M Y, h:i A') }}
                                        <br>
                                        @if (!$task->type == 'tasks')
                                            Reason:
                                        @endif

                                        {{ $task->message }}
                                    </li>
                                </ul>
                                <br>
                            @endforeach

                            </a>
                        </li>


                        <li>
                            @if (!$hasUnread)
                                <h4>no meassage</h4>
                            @endif

                        </li>


                    </ul>
                </div>
                <li>
                    <div id="user_profile" class="no-class" onclick="handleProfileIcon(this)">
                        {{ strtoupper(substr($admin_profile->name, 0, 1)) }}</div>
                </li>
                <div id="profile_setup_popup" class="display-zero">
                    <div class="profile-popup-container">
                        <div class="profile-popup-inner">
                            <i class="fa fa-user"></i>
                            <center id="user_name">{{ $admin_profile->name ?? '' }}.</center>
                            <a href="{{ route('admin.password') }}" <button id="change_password">CHANGE
                                PASSWORD</button></a>
                        </div>
                        <div class="profile-features">
                            <a href="{{ route('admin.profile') }}">
                                <button id="profile" class="blue-bg-button kk">Profile</button></a>
                            <a href="{{ route('Admin.Adminlogout') }}">
                                <button id="sign_out" class="blue-bg-button kk">Sign Out</button>
                            </a>
                        </div>
                    </div>
                </div>
            </ul>


        </div>
    </nav>
    <style>
        .kk {
            width: 100px;
        }
    </style>
    <section id="main_content_section">
        <section id="side_bar_parent_fixed">
            <div id="side_bar" class="side_bar_max">
                <div id="main_navigation">
                    MAIN NAVIGATION
                </div>
                <ul id="side_bar_main_ul">
                    <li class="one_bar">
                        <a href="{{ route('mains_admin') }}"><i class="fa fa-bars"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="one_bar">
                        <a href="{{ route('admin.attendance') }}"><i class="fa fa-bars"></i>
                            <span>Attendance</span></a>
                    </li>
                    <li class="more_then_one_bar">
                        <a href=""><i class="fa fa-bars"></i> <span>User</span> <i
                                class="fa fa-angle-down"></i></a>

                    </li>
                    <ul class="dropdown min-dropdown">
                        <li>
                            <a href="{{ route('user.add') }}">Add</a>
                        </li>
                        <li>
                            <a href="{{ route('user.view') }}">View</a>
                        </li>
                    </ul>
                    <li class="one_bar">
                        <a href="{{ route('admin.holiday') }}"><i class="fa fa-bars"></i> <span>Holidays</span></a>
                    </li>

                    <li class="one_bar">
                        <a href="{{ route('admin.work.home') }}"><i class="fa fa-bars"></i> <span>Work Form
                                Home</span></a>
                    </li>
                    <li class="one_bar">
                        <a href="{{ route('admin.leaves') }}"><i class="fa fa-bars"></i> <span>Leaves</span></a>
                    </li>
                    <li class="one_bar">
                        <a href="{{ route('admin.project') }}"><i class="fa fa-bars"></i> <span>Project</span></a>
                    </li>
                    <li class="one_bar">
                        <a href="{{ route('admin.tasks') }}"><i class="fa fa-bars"></i> <span>Tasks</span></a>
                    </li>
                    <li class="one_bar">
                        <a href="{{ route('admin.sallery') }}"><i class="fa fa-bars"></i> <span>Sallery</span></a>
                    </li>



                </ul>

            </div>

        </section>
