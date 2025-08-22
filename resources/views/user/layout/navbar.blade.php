<?php
use App\Models\User;
use App\Models\AdminNotifications;

$user = auth()->guard('web')->user();
$profiles = User::where('id', $user->employee_id)->first();

$notifictionCount = AdminNotifications::where(function ($query) {
    $query->where('type', 'holidays')->orWhere(function ($q) {
        $q->whereIn('type', ['works', 'tasks', 'sellery', 'leave', 'work_forms'])->where('user_id', auth()->id());
    });
})
    ->where('is_read', false)
    ->count();

$notifictionHoliays = AdminNotifications::where('type', 'holidays')->where('is_read', false)->get();
$notifictionHoliaysexists = AdminNotifications::where('type', 'holidays')->where('is_read', false)->exists();

$notifictionwork = AdminNotifications::whereIn('type', ['works', 'work_forms'])
    ->where('user_id', auth()->id())
    ->where('is_read', false)
    ->get();

$notifictionWorkexists = AdminNotifications::whereIn('type', ['works', 'work_forms'])
    ->where('user_id', auth()->id())
    ->where('is_read', false)
    ->exists();

$notifictionTask = AdminNotifications::where('type', 'tasks')
    ->where('user_id', auth()->id())
    ->where('is_read', false)
    ->get();

$notifictionTaskexists = AdminNotifications::where('type', 'tasks')
    ->where('user_id', auth()->id())
    ->where('is_read', false)
    ->exists();

$notifictionsellery = AdminNotifications::where('type', 'sellery')
    ->where('user_id', auth()->id())
    ->where('is_read', false)
    ->get();

$notifictionselleryexists = AdminNotifications::where('type', 'sellery')
    ->where('user_id', auth()->id())
    ->where('is_read', false)
    ->exists();

$notileave = AdminNotifications::where('type', 'leave')
    ->where('user_id', auth()->id())
    ->where('is_read', false)
    ->get();

$notileaveexists = AdminNotifications::where('type', 'leave')
    ->where('user_id', auth()->id())
    ->where('is_read', false)
    ->exists();

$exitnoti = AdminNotifications::where('is_read', false)->exists();

?>

<style>
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

<section id="main_container_site" class="navbars">
    <nav id="navbar">
        <div id="main_logo_container" class="navbar-logo-container-max">
            <a href="{{ route('mains_user') }}">
                <img src="{{ url('/') }}/public/img/hrmsaura.webp" alt="logo_web_site" /></a>
            <a href="{{ route('mains_user') }}">

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

            <ul id="profile_notification_container">
                <li id="fa-bell-icon" onclick="handleNotificationBell(this)">
                    <i class="fa fa-bell"></i>

                    <span id="notification_header" class="notification-counter">
                        <!-- white the logic here if the notifictions are more then 9 then it show 9+ -->
                        {{ $notifictionCount }}

                    </span>


                </li>
                <div id="notification_pannel" class="display-zero no-class">
                    <ul>
                        <!-- <li>
                  when there is no notification
                  No notifications
                </li> -->

                        <li class="li-noti">

                            @if ($notifictionHoliaysexists)
                                <a href="{{ route('holiday.user') }}">
                                    <h5>Holidays Notificatin</h5>
                            @endif
                            @foreach ($notifictionHoliays as $holidayes)
                                <ul>
                                    <li> {{ $holidayes->name }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($holidayes->created_at)->format('d M Y, h:i A') }}
                                        <br>
                                        Description:
                                        {{ $holidayes->message }}
                                    </li>
                                </ul>
                                <br>
                            @endforeach
                            </a>
                        </li>
                        <li class="li-noti">

                            @if ($notifictionWorkexists)
                                <a href="{{ route('work_home.user') }}">
                                    <h5>Work Form Home Notificatin</h5>
                            @endif
                            @foreach ($notifictionwork as $work)
                                <ul>
                                    <li>
                                        @if ($work->type == 'works')
                                            Reason: {{ $work->name }}
                                        @endif
                                        <br>
                                        {{ \Carbon\Carbon::parse($work->created_at)->format('d M Y, h:i A') }}
                                        <br>
                                        @if ($work->type == 'works')
                                            Location:
                                            {{ $work->name }}
                                        @endif
                                        {{ $work->message }}
                                    </li>
                                </ul>
                                <br>
                            @endforeach
                            </a>
                        </li>
                        <li class="li-noti">

                            @if ($notifictionTaskexists)
                                <a href="{{ route('user.task') }}">
                                    <h5>Task Notificatin</h5>
                            @endif
                            @foreach ($notifictionTask as $task)
                                <ul>
                                    <li> Task : {{ $task->name }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($task->created_at)->format('d M Y, h:i A') }}
                                        <br>
                                        {{ $task->message }}
                                    </li>
                                </ul>
                                <br>
                            @endforeach
                            </a>
                        </li>
                        <li class="li-noti">

                            @if ($notifictionselleryexists)
                                <a href="{{ route('user.sallery') }}">
                                    <h5>Sellary Notificatin</h5>
                            @endif
                            @foreach ($notifictionsellery as $sellery)
                                <ul>
                                    <li> Name: {{ $sellery->name }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($sellery->created_at)->format('d M Y, h:i A') }}
                                        <br>
                                        Message:
                                        {{ $sellery->message }}
                                    </li>
                                </ul>
                                <br>
                            @endforeach
                            </a>
                        </li>
                        <li class="li-noti">

                            @if ($notileaveexists)
                                <a href="{{ route('user.leaves') }}">
                                    <h5>Leave Notificatin</h5>
                            @endif
                            @foreach ($notileave as $leaves)
                                <ul>
                                    <li> Name: {{ $leaves->user->name }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($leaves->created_at)->format('d M Y, h:i A') }}
                                        <br>
                                        Message:
                                        {{ $leaves->message }}
                                    </li>
                                </ul>
                                <br>
                            @endforeach
                            </a>
                        </li>

                        <li>
                            @if (!$exitnoti)
                                <h4>No Message</h4>
                            @endif
                        </li>



                    </ul>
                </div>
                <li>

                    <div id="user_profile" class="no-class" onclick="handleProfileIcon(this)">
                        {{ strtoupper(substr($profiles->name, 0, 1)) }}
                    </div>
                </li>
                <div id="profile_setup_popup" class="display-zero">
                    <div class="profile-popup-container">
                        <div class="profile-popup-inner">
                            <i class="fa fa-user"></i>
                            <center id="user_name">{{ $profiles->name ?? '' }}</center>
                            <a href="{{ route('user.password') }}">
                                <button id="change_password">CHANGE PASSWORD</button></a>
                        </div>
                        <div class="profile-features">
                            <a href="{{ route('user.profile') }}">
                                <button id="profile" class="blue-bg-button kk">Profile</button></a>

                            <a href="{{ route('user.Userlogout') }}">
                                <button id="sign_out" class="blue-bg-button kk">Sign Out</button></a>
                        </div>
                    </div>
                </div>
            </ul>


        </div>
    </nav>
    <style>
        .kk {
            width: 60px;
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
                        <a href="{{ route('mains_user') }}"><i class="fa-solid fa-table-columns"></i>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="one_bar">
                        <a href="{{ route('attendance.user') }}"><i class="fa-solid fa-table-columns"></i>
                            <span>Attendance</span></a>
                    </li>


                    <li class="one_bar">
                        <a href="{{ route('holiday.user') }}"><i class="fa fa-money-check-dollar"></i> <span>
                                Holiday</span></a>
                    </li>

                    <li class="one_bar">
                        <a href="{{ route('work_home.user') }}"><i class="fa-solid fa-hand"></i><span>Work form
                                home</span></a>
                    </li>

                    <li class="one_bar">
                        <a href="{{ route('user.leaves') }}"><i class="fa-solid fa-comments-dollar"></i>
                            <span>Leaves</span></a>
                    </li>
                    <li class="one_bar">
                        <a href="{{ route('user.task') }}"><i class="fa-solid fa-comments-dollar"></i>
                            <span>Tasks</span></a>
                    </li>
                    <li class="one_bar">
                        <a href="{{ route('user.sallery') }}"><i class="fa-solid fa-table-columns"></i>
                            <span>Sallery</span></a>
                    </li>
                    <li class="one_bar">
                        <a href="{{ route('internship.user') }}"><i class="fa-solid fa-table-columns"></i>
                            <span>Internship Tap-in</span></a>
                    </li>


                    <li>

                    </li>
                    <!-- <li class="more_then_one_bar">
                            <a href=""><i class="fa fa-bars"></i> <span>Dashboard</span><i class="fa fa-angle-down"></i></i></a>
             
          </li>
          <ul class="dropdown min-dropdown">
              <li>
                  <a href="">content</a>
              </li>
              <li>
                  <a href="">content</a>
              </li>
          </ul> -->


                </ul>

            </div>

        </section>
