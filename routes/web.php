<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Dashboard\ParticipantController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register/information/ticketed-events', function () {
    return view('register-information.ticketed');
});

Route::get('/register/information/group-organizers', function () {
    return view('register-information.tour-operator');
});

Route::prefix('/details')->group(function() {
    Route::get('/show/{id}', [ParticipantController::class, 'show'])->middleware('auth');
    Route::get('/modify/{id}', [ParticipantController::class, 'modify'])->middleware('auth', 'verified');
    Route::get('/edit/{id}', [ParticipantController::class, 'edit'])->middleware('auth', 'verified');
    Route::put('/update/{id}', [ParticipantController::class, 'update'])->middleware('auth', 'verified');
    Route::put('/undo/{id}', [ParticipantController::class, 'undo'])->middleware('auth', 'verified');
    Route::delete('/destroy/{id}', [ParticipantController::class, 'destroy'])->middleware('auth');
});

Route::prefix('/reports')->group(function() {
    Route::get('/user-summary', [ReportController::class, 'index_summary'])->middleware('auth', 'is_admin');
    Route::get('/login-summary', [ReportController::class, 'index_login'])->middleware('auth', 'is_admin');
});

Route::prefix('/register')->group(function() {
    Route::get('/', [RegisterController::class, 'index']);
    Route::get('/information', [RegisterController::class, 'index_info']);
    Route::get('/create ', [RegisterController::class, 'form']);
    Route::post('/store ', [RegisterController::class, 'store']);
});

Route::prefix('/manage')->group(function() {
    Route::get('/unpaid', [ParticipantController::class, 'index_unpaid'])->middleware('auth', 'verified', 'is_admin');
    Route::get('/paid', [ParticipantController::class, 'index_paid'])->middleware('auth', 'verified', 'is_admin');
    Route::get('/admin', [AdminController::class, 'index'])->middleware('auth', 'verified', 'is_admin');
    Route::get('/admin/create', [AdminController::class, 'create'])->middleware('auth', 'verified', 'is_admin');
    Route::get('/admin/edit', [AdminController::class, 'edit'])->middleware('auth', 'verified', 'is_admin');
    Route::post('/admin/store', [AdminController::class, 'store'])->middleware('auth', 'verified', 'is_admin');
    Route::put('/admin/edit/{id}', [AdminController::class, 'update'])->middleware('auth', 'verified', 'is_admin');
    Route::delete('/admin/destroy/{id}', [AdminController::class, 'destroy'])->middleware('auth', 'verified', 'is_admin');
});

Route::prefix('/dashboard')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->middleware('auth', 'verified');     
});


// email verification Route Handler
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');




Auth::routes([
    'register' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
