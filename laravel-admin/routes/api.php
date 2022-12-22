<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backsite\UserController;
use App\Http\Controllers\backsite\AuthController;
use App\Http\Controllers\RoleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login',[AuthController::class,'Login'])->name('login');
Route::post('register',[AuthController::class,'Register']);
Route::group(['middleware'=>'auth:api'],function(){
    Route::get('user',[UserController::class,'user']);
    Route::put('user/info',[UserController::class,'userInfo']);
    Route::put('user/password',[UserController::class,'userPassword']);
    
    
    Route::get('users',[UserController::class,'index']);
    Route::get('user/{id}',[UserController::class,'show']);
    Route::post('user',[UserController::class,'store']);
    Route::put('user/{id}',[UserController::class,'update']);
    Route::delete('user/{id}',[UserController::class,'destroy']);
    Route::apiResource('roles',RoleController::class);
});



