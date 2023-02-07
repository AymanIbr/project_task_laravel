<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\authController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use App\Jobs\TestJob;
use App\Mail\AdminWelcomeEmail;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Route;



Route::prefix('store')->middleware('guest:user,admin')->group(function () {
    Route::get('/{guard}/login', [authController::class, 'ShowLogin'])->name('login');
    Route::post('/login', [authController::class, 'login']);

    Route::get('forgot-password', [ResetPasswordController::class, 'showForgotPassword'])->name('password.forgot');
    Route::post('forgot-password', [ResetPasswordController::class, 'sendReetLink']);
    //هذا الرابط بنيته ثابتة
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetPassword'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);
});


Route::prefix('store/admin')->middleware(['auth:admin', 'verified'])->group(function () {

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles.permissions', RolePermissionController::class);
    Route::resource('users.permissions', UserPermissionController::class);


    Route::resource('admins', AdminController::class);
});


Route::prefix('store/admin')->middleware(['auth:admin,user', 'verified'])->group(function () {


    Route::get('/', [DashboardController::class, 'index'])->name('HomePage');

    Route::resource('cities', CityController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
    Route::resource('notes',NoteController::class);
    Route::resource('sub-categories',SubCategoryController::class);


    Route::get('notifications', [NotificationController::class, 'index'])->name('user.notification');

    Route::get('edit-password', [authController::class, 'changePassword'])->name('change-password');
    Route::put('update-password', [authController::class, 'updatePassword']);

    Route::get('logout', [authController::class, 'logout'])->name('logout');
});

Route::prefix('store')->middleware('auth:admin')->group(function () {
    Route::get('email-verify', [EmailVerificationController::class , 'showEmailVerification'])->name('verification.notice');
    // throtttle تعني مرة كل دقيقة وايضا ناخره دقيقة
    Route::get('email-verify/send',[EmailVerificationController::class,'sendVerificationEmail'])->middleware('throttle:1,1');
    //signed نظيفها لكي نتأكد ان الريكوست من السيستم الخاص بنا
    Route::get('verify/{id}/{hash}',[EmailVerificationController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');
});

// Route::get('email',function(){
//     return new AdminWelcomeEmail( User::first());
// });


// Route::get('/password',function(){
//     return bcrypt('password');
// });
/////////// Test Job

Route::get('test-job',function(){
    // (new TestJob())->handle();
    //تنفيذ بطريقة تانية
    //في هذه الحالة يتم اضافتها في جدول ال job
        // (new TestJob())->dispatch()->delay(5);
        // انشاء 10 جووب
        // foreach(range(1,10) as $i){
        //     TestJob::dispatch();
        // }

        foreach(range(1,10) as $i){
            if($i % 2 ){
                TestJob::dispatch()->onQueue('Even');
            }else{
                TestJob::dispatch()->onQueue('Odd');
            }
        }

});
