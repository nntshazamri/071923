<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Register\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('home');
});
Route::get("/about", function(){
    return view('about');
});
Route::get("/contact", function(){
    return view('contact');
});
Route::get('/test', [TestController::class, 'test']);

//login related
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

//register user related
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'registered'])->name('register.submit');


//userprofile related
Route::get('/userprofile', [UserProfileController::class, 'index'])->name('userprofile');

Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');

//other pages frontend only
Route::get('/datamonitoring', function () {
    return view('datamonitoring'); 
});

Route::get('/farmdetails', function () {
    return view('farmdetails'); 
});
