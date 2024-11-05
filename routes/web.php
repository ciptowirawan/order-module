<?php

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrationController;
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
    if (!auth()->user()) {
        $registered = false;
    } else {
        $registered = Registration::where('user_id', auth()->user()->id)->exists();
    }

    return view('welcome', compact('registered'));
});

// Route::get('/register/information/ticketed-events', function () {
//     return view('register-information.ticketed');
// });

// Route::get('/register/information/group-organizers', function () {
//     return view('register-information.tour-operator');
// });

// Route::prefix('/details')->group(function() {
//     Route::get('/show/{id}', [ParticipantController::class, 'show'])->middleware('auth');
//     Route::get('/modify/{id}', [ParticipantController::class, 'modify'])->middleware('auth', 'verified');
//     Route::get('/edit/{id}', [ParticipantController::class, 'edit'])->middleware('auth', 'verified');
//     Route::put('/update/{id}', [ParticipantController::class, 'update'])->middleware('auth', 'verified');
//     Route::put('/undo/{id}', [ParticipantController::class, 'undo'])->middleware('auth', 'verified');
//     Route::delete('/destroy/{id}', [ParticipantController::class, 'destroy'])->middleware('auth');
// });

// Route::prefix('/reports')->group(function() {
//     Route::get('/user-summary', [ReportController::class, 'index_summary'])->middleware('auth', 'is_admin');
//     Route::get('/login-summary', [ReportController::class, 'index_login'])->middleware('auth', 'is_admin');
// });

Route::prefix('/register')->group(function() {
    Route::get('/', [RegistrationController::class, 'index']);
    Route::get('/information', [RegistrationController::class, 'index_info']);
    Route::get('/create ', [RegistrationController::class, 'form']);
    Route::post('/store ', [RegistrationController::class, 'store_member']);
    Route::post('/event ', [RegistrationController::class, 'store_event_participant'])->middleware('is_active_member');
});

Route::prefix('/details')->group(function() {
    Route::get('/show/{member}', [ParticipantController::class, 'show'])->middleware('auth', 'is_admin');
});

Route::prefix('/manage')->group(function() {
    Route::get('/unpaid', [ParticipantController::class, 'index_unpaid'])->middleware('auth', 'is_admin');
    Route::get('/paid', [ParticipantController::class, 'index_paid'])->middleware('auth', 'is_admin');
    Route::get('/paid/sortByDistrict/{district}', [ParticipantController::class, 'sortPaidParticipantsByDistrict'])->middleware('auth', 'is_admin')->name('sortByDistrict');
    Route::get('/export-pdf-unpaid', [ParticipantController::class, 'exportUnpaidParticipantsAsPdf'])->middleware('auth', 'is_admin')->name('export-unpaid-pdf');
    Route::get('/export-pdf-paid', [ParticipantController::class, 'exportPaidParticipantsAsPdf'])->middleware('auth', 'is_admin')->name('export-paid-pdf');
    Route::get('/export-pdf-paid/{district}', [ParticipantController::class, 'exportPaidAsPdfParticipantsByDistrict'])->middleware('auth', 'is_admin')->name('export-paid-pdf-by-district');

    Route::get('/admin', [AdminController::class, 'index'])->middleware('auth', 'is_admin');
    Route::get('/admin/create', [AdminController::class, 'create'])->middleware('auth', 'is_admin');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->middleware('auth', 'is_admin');
    Route::post('/admin/store', [AdminController::class, 'store'])->middleware('auth', 'is_admin');
    Route::put('/admin/update/{id}', [AdminController::class, 'update'])->middleware('auth', 'is_admin');
    Route::delete('/admin/destroy/{id}', [AdminController::class, 'destroy'])->middleware('auth', 'is_admin');
});

Route::prefix('/dashboard')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->middleware('is_active_member');     
    Route::get('/presence-unattended', [PresenceController::class, 'index'])->middleware('auth', 'is_admin'); 
    Route::get('/presence-attended', [PresenceController::class, 'index_attended'])->middleware('auth', 'is_admin'); 
    Route::get('/participants', [PresenceController::class, 'index_participants'])->middleware('auth', 'is_admin'); 
    // Route::get('/', [DashboardController::class, 'index'])->middleware('auth');     
    Route::get('/presence/update', [PresenceController::class, 'showCheckStatus'])->middleware('auth');
    Route::get('/export-pdf-unattended/{district}', [PresenceController::class, 'exportUnattendedParticipantsByDistrict'])->middleware('auth', 'is_admin')->name('export-unattended-pdf-by-district');
    Route::get('/export-pdf-participants/{district}', [PresenceController::class, 'exportParticipantsByDistrict'])->middleware('auth', 'is_admin')->name('export-participants-pdf-by-district');
    Route::get('/participants/{district}', [PresenceController::class, 'sortParticipantsByDistrict'])->middleware('auth', 'is_admin')->name('sort-participants-by-district');
    Route::get('/export-pdf-attended/{district}', [PresenceController::class, 'exportAttendedParticipantsByDistrict'])->middleware('auth', 'is_admin')->name('export-attended-pdf-by-district');
    Route::get('/presence-attended/{district}', [PresenceController::class, 'sortAttendedByDistrict'])->middleware('auth', 'is_admin')->name('sort-attended-by-district');
});


// // email verification Route Handler
// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
 
//     return redirect('/dashboard');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
 
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.resend');




Auth::routes([
    'register' => false
]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
