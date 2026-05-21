<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\AttendanceController;
use App\Models\Membership;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH DASHBOARD (NOW POINTING TO ADMIN UI)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return view('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES (MEMBER SIDE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // MEMBER VIEWS
    Route::get('/membership', function () {
        return view('membership');
    })->name('membership');

    Route::get('/attendance', function () {
        return view('attendance');
    })->name('attendance');

    // ATTENDANCE CHECK IN
    Route::post('/attendance/checkin', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');

    // MEMBERSHIP SUBMISSION
    Route::post('/membership', [MembershipController::class, 'store']);
});


Route::middleware(['auth', 'admin'])->group(function () {

    // ADMIN DASHBOARD
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    // ADMIN PAGES
    Route::get('/admin/payments', function () {
        $memberships = Membership::with('member.user')->latest()->get();
        return view('admin.payments', compact('memberships'));
    });

    Route::get('/admin/workouts', [WorkoutPlanController::class, 'index']);

    // MEMBERSHIP MANAGEMENT
    Route::get('/admin/memberships', [MembershipController::class, 'index']);

    Route::post('/membership/{id}/activate', [MembershipController::class, 'activate']);
    Route::post('/membership/{id}/reject', [MembershipController::class, 'reject']);

    // MEMBERS CRUD
    Route::resource('members', MemberController::class);

    // WORKOUT ASSIGNMENT
    Route::post('/admin/workouts', [WorkoutPlanController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';