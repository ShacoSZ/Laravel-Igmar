<?php

use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthUserController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Get Routes
Route::get('/', [UserController::class,'index']) ->name('index');
Route::get('/register', [UserController::class,'Register']) ->name('register');
Route::get('/login', [UserController::class,'Login']) ->name('login');

Route::get('/user/verify',[AuthUserController::class,'verify'])->name('verify');
route::get('admin/home', [UserController::class,'AdminHome'])->name('AdminHome');
route::get('/user/logout',[UserController::class,'logout'])->name('LogoutUser');

Route::middleware(['auth:sanctum'])->group(function () {
    route::get('/test',[UserController::class,'test'])->name('test');
    route::get('/User/Admin',[AdminUserController::class,'index'])->name('AdminHome');   
});
//Post Routes
route::post('/user/register',[UserController::class,'CreateUser'])->name('CreateUser');
route::post('/user/login',[UserController::class,'LoginUser'])->name('LoginUser');
route::post('/user/verify',[AuthUserController::class,'verifyTwoFactor'])->name('verifyTwoFactor');
