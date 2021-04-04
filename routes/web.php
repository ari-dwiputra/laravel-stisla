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


Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => ['auth']], function () {
	Route::get('/', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
	Route::get('/profile', [App\Http\Controllers\Web\ProfileController::class, 'index'])->name('home');
	Route::post('/profile/update', [App\Http\Controllers\Web\ProfileController::class, 'update'])->name('profile/update');
	Route::post('/profile/password', [App\Http\Controllers\Web\ProfileController::class, 'changePassword'])->name('profile/password');
	


	//User
	Route::get('/user', [App\Http\Controllers\Web\UserController::class, 'index'])->name('user');
	Route::post('/user/getData', [App\Http\Controllers\Web\UserController::class, 'getData'])->name('user/getData');
	Route::post('/user/store', [App\Http\Controllers\Web\UserController::class, 'store'])->name('user/store');
	Route::get('/user/{id}', [App\Http\Controllers\Web\UserController::class, 'show'])->name('user');
	Route::post('/user/update', [App\Http\Controllers\Web\UserController::class, 'update'])->name('user/update');
	Route::post('/user/password', [App\Http\Controllers\Web\UserController::class, 'changePassword'])->name('user/password');
	Route::post('/user/profile', [App\Http\Controllers\Web\UserController::class, 'changeProfile'])->name('user/profile');
    Route::post('/user/delete/{id}',[App\Http\Controllers\Web\UserController::class, 'destroy'])->name('user/delete');

	//Role
	Route::get('/role', [App\Http\Controllers\Web\RoleController::class, 'index'])->name('role');
	Route::post('/role/getData', [App\Http\Controllers\Web\RoleController::class, 'getData'])->name('role/getData');
	Route::get('/role/create', [App\Http\Controllers\Web\RoleController::class, 'create'])->name('role/create');
	Route::post('/role/create', [App\Http\Controllers\Web\RoleController::class, 'store'])->name('role/create');
	Route::get('/role/edit/{id}', [App\Http\Controllers\Web\RoleController::class, 'edit'])->name('role/edit');
	Route::post('/role/edit/{id}', [App\Http\Controllers\Web\RoleController::class, 'update'])->name('role/edit');
    Route::post('/role/delete/{id}',[App\Http\Controllers\Web\RoleController::class, 'destroy'])->name('role/delete');
});

