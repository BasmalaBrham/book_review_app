<?php

use App\Http\Controllers\AccountController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('account/register',[AccountController::class,'register'])->name('account.register');
Route::post('account/register',[AccountController::class,'processRegister'])->name('account.processRegister');

//login
Route::get('account/login',[AccountController::class,'login'])->name('account.login');
Route::post('account/login',[AccountController::class,'processlogin'])->name('account.processLogin');
