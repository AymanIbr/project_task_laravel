<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Policies\CategoryPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function(){

    Route::post('login',[ApiAuthController::class, 'login']);

    Route::post('forget-password',[ApiAuthController::class , 'foregetPassword'])->middleware('throttle:3,1');
    Route::post('reset-password',[ApiAuthController::class , 'resetPassword']);

});

Route::prefix('auth')->middleware('auth:api')->group(function(){
    Route::get('logout',[ApiAuthController::class ,'logout' ]);

    Route::post('change-password',[ApiAuthController::class , 'changePassword']);
});

Route::middleware('auth:api')->group(function(){

    Route::apiResource('categories',CategoryApiController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
