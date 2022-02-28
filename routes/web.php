<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\SocialGoogleController;
use App\Http\Controllers\UserController;



Route::post('login/google',[SocialGoogleController::class,'Login']); 
Route::get('auth/google', [SocialGoogleController::class, 'redirectToGoogle'])->name('loginGoogle');
Route::get('callback/google', [SocialGoogleController::class, 'genToken']);


Route::post('getToken',[UserController::class, 'getToken']);

Route::post('auth/renovarToken', [UserController::class, 'renovarToken']);

Route::post('user/info', [UserController::class, 'getUserInfo']);