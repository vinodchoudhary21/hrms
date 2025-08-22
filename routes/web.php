<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\User\DashboardsController;
use App\Http\Controllers\Admin\UserAddController;
use App\Http\Controllers\User\UserLoginController;
use App\Http\Controllers\User\UserProfilleController;
use App\Http\Controllers\Admin\AdminProfileContorller;
use App\Http\Controllers\Admin\AdminPasswordController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ForgetPasswordController;
use App\Http\Controllers\User\UserPasswordController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\User\UserHolidayController;
use App\Http\Controllers\Admin\WorkFormHomeController;
use App\Http\Controllers\User\UserWorkFormHomeController;
use App\Http\Controllers\User\UserLeavesController;
use App\Http\Controllers\Admin\LeavesController;
use App\Http\Controllers\Admin\TasksController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SellaryController;
use App\Http\Controllers\User\UserAttendanceController;
use App\Http\Controllers\User\UserForgetPasswordController;
use App\Http\Controllers\User\UserInternshipController;
use App\Http\Controllers\User\UserSalleryController;
use App\Http\Controllers\User\UserTaskController;

Route::middleware('AdminMiddlewares')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('admin', 'admin_stor')->name('mains_admin');
    });
    Route::controller(AdminProfileContorller::class)->group(function () {
        Route::get('admin/profile', 'admin_profile')->name('admin.profile');
        Route::post('admin/update', 'profile_updates')->name('admin_profile.update');
    });
    Route::controller(AdminPasswordController::class)->group(function () {
        Route::get('admin/password', 'admin_password')->name('admin.password');
        Route::post('admin/change',  'admin_changepass')->name('admin.changepass');
    });
    Route::controller(HolidayController::class)->group(function () {
        Route::get('admin/holiday', 'admin_holiday')->name('admin.holiday');
        Route::post('admin/holiday/stor', 'holiday_store')->name('holiday.store');
        Route::get('admin/holiday/add', 'add_holiday')->name('add.holiday');
        Route::get('admin/delect/{id}', 'holiday_delect')->name('holidays.delects');
    });
    Route::post('admin/holiday/update/{id}', [HolidayController::class, 'holiday_update'])->name('holiday.update');


    Route::controller(WorkFormHomeController::class)->group(function () {
        Route::get('admin/work', 'admin_work')->name('admin.work.home'); // work list
        Route::get('admin/addwork', 'admin_addwork')->name('admin.addwork'); // form
        Route::post('admin/add/store', 'addwork_store')->name('addwork.store'); // store
        Route::get('user/work/delect/{id}', 'workadd_delect')->name('workadd.delect');
        Route::post('/admin/work/update/',  'work_update')->name('works.updates');
    });



    Route::controller(LeavesController::class)->group(function () {
        Route::get('admin/leaves', 'admin_leaves')->name('admin.leaves');
        Route::get('admin/leaves/delect/{id}', 'admin_leaves_delect')->name('admin.leaves_delect');
        Route::post('admin/leaves/update', 'leaves_update')->name('leaves.update');
    });
    Route::controller(ProjectController::class)->group(function () {
        Route::get('admin/project', 'admin_project')->name('admin.project');
        Route::get('admin/addproject', 'admin_addproject')->name('admin.addproject');
        Route::post('admin/project/store', 'project_store')->name('project.store');
        Route::get('admin/project/delect/{id}', 'project_delect')->name('project.delect');
        Route::post('admin/project/update', 'project_update')->name('project.update');
    });
    Route::controller(TasksController::class)->group(function () {
        Route::get('admin/tasks', 'admin_tasks')->name('admin.tasks');
        Route::get('admin/addtasks', 'admin_addtasks')->name('admin.addtasks');
        Route::post('admin/task/store', 'tasks_store')->name('tasks.store');
        Route::get('admin/task/delect/{id}', 'tasks_delect')->name('tasks.delect');
        Route::post('admin/task/delect', 'tasks_update')->name('tasks.updates');
    });


    Route::controller(SellaryController::class)->group(function () {
        Route::get('admin/sallery', 'sallerys')->name('admin.sallery');
        Route::get('admin/addsallery', 'add_sallerys')->name('admin.addsallery');
        Route::post('admin/sallery/store', 'add_storesallerys')->name('admin.storesallery');
    });
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('admin/attendances', 'admin_attendance')->name('admin.attendance');
    });



    Route::prefix('Admin')->controller(UserAddController::class)->group(function () {
        Route::get('user_add', 'user_add')->name('user.add');
        Route::get('user_view', 'user_view')->name('user.view');
        Route::get('del_view/{id}', 'del_view')->name('del.view');
        Route::post('/user/store', 'store')->name('user.store');
        Route::post('user/update', 'user_update')->name('user.update');
    });
});

Route::prefix('Admin')->controller(LoginController::class)->group(function () {
    Route::get('login', 'login_add')->name('login.add');
    Route::post('login/store', 'login_admin_Send')->name('admin.login.send');
    Route::get('logout', 'adminlogout')->name('Admin.Adminlogout');
});

Route::prefix('Admin')->controller(ForgetPasswordController::class)->group(function () {
    Route::get('forget/password', 'forget_password')->name('forget.password');
    Route::post('forget/verify', 'verify')->name('ADMIN.Check.Verify');
    Route::post('forget/otp', 'check_otp')->name('ADMIN.Check.otp');
    Route::post('forget/new_pass', 'new_pass')->name('ADMIN.New.pass');
});



Route::get('/salary-slip/{id}', [SellaryController::class, 'generatePdf'])->name('salary.slip.pdf');













Route::prefix('/')->controller(UserLoginController::class)->group(function () {
    Route::get('login_users', 'loginn_user')->name('login.user');
    Route::post('Login_Send', 'login_user_Send')->name('User.Login.Send');
    Route::get('Userlogout', 'Userlogout')->name('user.Userlogout');
});


Route::middleware('UserMiddlewere')->group(function () {
    Route::prefix('/')->controller(DashboardsController::class)->group(function () {
        Route::get('user', 'mains_user')->name('mains_user');
    });
    Route::prefix('/')->controller(UserProfilleController::class)->group(function () {
        Route::get('user/profile', 'user_profile')->name('user.profile');
        Route::post('profile/update', 'profile_update')->name('profile.update');
    });
    Route::prefix('/')->controller(UserPasswordController::class)->group(function () {
        Route::get('user/password', 'user_password')->name('user.password');
        Route::post('password/update', 'password_update')->name('password.update');
    });
    Route::prefix('/')->controller(UserHolidayController::class)->group(function () {
        Route::get('user/holiday', 'holiday_user')->name('holiday.user');
    });
    Route::prefix('/')->controller(UserWorkFormHomeController::class)->group(function () {
        Route::get('user/work', 'work_form')->name('work_home.user');
        Route::get('user/add', 'add_work')->name('add.work.user');
        Route::post('user/stor', 'work_store')->name('work.store');
        Route::get('user/delect/{id}', 'work_delect')->name('work.delect');
    });
    Route::prefix('/')->controller(UserLeavesController::class)->group(function () {
        Route::get('user/leaves', 'user_leaves')->name('user.leaves');
        Route::get('user/addleaves', 'user_addleaves')->name('user.addleaves');
        Route::post('user/leaves/store', 'leaves_store')->name('leaves.store');
        Route::get('user/leaves/delect/{id}', 'leaves_delect')->name('leaves.delect');
    });
    Route::prefix('/')->controller(UserTaskController::class)->group(function () {
        Route::get('user/task', 'user_task')->name('user.task');
        Route::get('user/task/delect/{id}', 'tasksuser_delect')->name('tasksuser.delect');
        Route::post('/admin/task/update', 'update')->name('task.update');
    });

    Route::prefix('/')->controller(UserSalleryController::class)->group(function () {
        Route::get('user/sallery', 'user_sallery')->name('user.sallery');
    });


    Route::prefix('/')->controller(UserAttendanceController::class)->group(function () {
        Route::get('user/attendanc', 'attendance_user')->name('attendance.user');

        Route::post('user/check', 'attendance')->name('check.in');
        Route::post('user/check/out', 'check_out')->name('check.out');
    });
    Route::prefix('/')->controller(UserInternshipController::class)->group(function () {
        Route::get('user/internship', 'internship_user')->name('internship.user');
    });
});


Route::prefix('/')->controller(UserForgetPasswordController::class)->group(function () {
    // Route::get('user/forget/', 'forgets_passwords')->name('forgets.user');

    Route::post('user/forget/verifys', 'verifys')->name('ADMIN.Check.Verifys');
    Route::post('user/forget/otps', 'check_otps')->name('ADMIN.Check.otps');
    Route::post('user/forget/new_passs', 'new_passs')->name('ADMIN.New.passs');
});
Route::get('user/forget/password', [UserForgetPasswordController::class, 'forgets_passwords'])->name('forgets.user');
