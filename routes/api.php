<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'auth','middleware'=>['auth:api','role:admin']], function(){
    Route::resource('user',UserController::class);
    Route::put('approve-request/{approval}',[UserController::class,'approve']);
    Route::put('decline-request/{approval}',[UserController::class,'decline']);
});
