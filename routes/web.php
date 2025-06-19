<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Register\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ContactInquiryController;
use App\Http\Controllers\DataMonitoringController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\PlotController;


Route::middleware('auth')->group(function () {
    Route::get('/datamonitoring', [DataMonitoringController::class, 'index'])->name('datamonitoring');
});

Route::get('/', function () {
    return view('home');
});
Route::get("/about", function(){
    return view('about');
});

Route::get('/test', [TestController::class, 'test']);

//login related
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // or wherever you want to redirect after logout
})->name('logout');

//register user related
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'registered'])->name('register.submit');


//userprofile related
Route::get('/userprofile', [UserProfileController::class, 'index'])->name('userprofile');
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');

//adminprofile
Route::get('/admindashboard', function () {
    return view('admindashboard');
})->name('admindashboard')->middleware('auth');
Route::get('/manageinquiries', [ContactInquiryController::class, 'index'])->name('manageinquiries');
Route::get('/manageusers', [UserController::class, 'index'])->name('manageusers');


//contact us related 
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact', [ContactInquiryController::class, 'store'])->name('contact.store');


Route::middleware('auth')->group(function () {
    // Farm routes
    Route::get('/farmdetails', [FarmController::class, 'index'])->name('farms.index');
    Route::get('/farmdetails/create', [FarmController::class, 'create'])->name('farms.create');
    Route::post('/farmdetails', [FarmController::class, 'store'])->name('farms.store');
    Route::get('/farmdetails/{farm}', [FarmController::class, 'show'])->name('farms.show');
    Route::get('/farmdetails/{farm}/edit', [FarmController::class, 'edit'])->name('farms.edit');
    Route::put('/farmdetails/{farm}', [FarmController::class, 'update'])->name('farms.update');
    Route::delete('/farmdetails/{farm}', [FarmController::class, 'destroy'])->name('farms.destroy');

    // Plot routes (nested under farm)
    Route::get('/farmdetails/{farm}/plots/create', [PlotController::class, 'create'])->name('plots.create');
    Route::post('/farmdetails/{farm}/plots', [PlotController::class, 'store'])->name('plots.store');
    Route::get('/farmdetails/{farm}/plots/{plot}/edit', [PlotController::class, 'edit'])->name('plots.edit');
    Route::put('/farmdetails/{farm}/plots/{plot}', [PlotController::class, 'update'])->name('plots.update');
    Route::delete('/farmdetails/{farm}/plots/{plot}', [PlotController::class, 'destroy'])->name('plots.destroy');

    Route::get('/datamonitoring', [DataMonitoringController::class, 'index'])->name('datamonitoring');
});