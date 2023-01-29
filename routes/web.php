<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\authController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Route;



Route::prefix('store')->middleware('guest:user,admin')->group(function () {
    Route::get('/{guard}/login', [authController::class, 'ShowLogin'])->name('login');
    Route::post('/login', [authController::class, 'login']);
});


Route::prefix('store/admin')->middleware('auth:admin')->group(function(){

    Route::resource('roles',RoleController::class);
    Route::resource('permissions',PermissionController::class);
    Route::resource('roles.permissions',RolePermissionController::class);
    Route::resource('users.permissions',UserPermissionController::class);


    Route::resource('admins',AdminController::class);
    Route::resource('users',UserController::class);

});


Route::prefix('store/admin')->middleware('auth:admin,user')->group(function(){


    Route::get('/',[DashboardController::class , 'index'])->name('HomePage');

    Route::resource('cities',CityController::class);
    Route::resource('categories',CategoryController::class);


    Route::get('notifications',[NotificationController::class , 'index'])->name('user.notification');

    Route::get('edit-password',[authController::class , 'changePassword'])->name('change-password');
    Route::put('update-password',[authController::class , 'updatePassword']);

    Route::get('logout',[authController::class , 'logout'])->name('logout');

});


Route::get('/password',function(){
    return bcrypt(123456789);
});
