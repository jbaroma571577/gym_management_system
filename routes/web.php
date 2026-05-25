<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\AttendanceController;
use App\Models\Membership;
use App\Models\Payment;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-auth', function () {
    return response()->json([
        'authenticated' => auth()->check(),
        'user_id' => auth()->id(),
        'user_email' => auth()->user()?->email,
        'session_id' => session()->getId(),
        'session_all' => session()->all(),
    ]);
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

Route::get('/dashboard/{any}', function () {
    return view('dashboard');
})->where('any', '^(?!build|api|storage|assets|favicon|@vite|mix|vendor|_ignition).*')->middleware(['auth']);

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

    /*
    |--------------------------------------------------------------------------
    | SPA API Endpoints (JSON)
    |--------------------------------------------------------------------------
    | These routes return JSON for the Vue SPA. They live under /api/* but
    | use the web middleware so they are session-authenticated.
    */
    Route::get('/api/today-status', [AttendanceController::class, 'getTodayStatus']);

    Route::get('/api/members', function () {
        return response()->json(auth()->user()->role === 'admin'
            ? \App\Models\Member::with(['user', 'membership'])->get()
            : (auth()->user()->member ? [\App\Models\Member::with(['user', 'membership'])->find(auth()->user()->member->id)] : []));
    });

    Route::get('/api/memberships', function () {
        if (auth()->user()->role === 'admin') {
            return response()->json(\App\Models\Membership::with('member.user')->latest()->get());
        }
        $member = auth()->user()->member;
        return response()->json($member ? $member->membership : null);
    });

    Route::get('/api/workout-plans', function () {
        if (auth()->user()->role === 'admin') {
            return response()->json(\App\Models\WorkoutPlan::with('member.user')->latest()->get());
        }
        $member = auth()->user()->member;
        return response()->json($member ? \App\Models\WorkoutPlan::with('member.user')->where('member_id', $member->id)->get() : []);
    });
    
    Route::get('/api/payments', [PaymentController::class, 'index']);
    Route::post('/api/payments', [PaymentController::class, 'store']);

    // API POST endpoints for SPA
    Route::post('/api/attendance/checkin', [AttendanceController::class, 'checkIn']);
    Route::post('/api/attendance/checkout', [AttendanceController::class, 'checkOut']);
    Route::post('/api/membership', [MembershipController::class, 'store']);
});


Route::middleware(['auth', 'admin'])->group(function () {

    // ADMIN DASHBOARD
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    // ADMIN PAGES
    Route::get('/admin/payments', function () {
        $payments = Payment::with('membership.member.user')->latest()->get();
        return view('admin.payments', compact('payments'));
    });

    Route::post('/payment/{id}/approve', [PaymentController::class, 'approve']);
    Route::post('/payment/{id}/reject', [PaymentController::class, 'reject']);

    Route::get('/admin/workouts', [WorkoutPlanController::class, 'index']);

    // MEMBERSHIP MANAGEMENT
    Route::get('/admin/memberships', [MembershipController::class, 'index']);

    // Admin API endpoints
    Route::get('/api/admin/members', function () {
        return response()->json(\App\Models\Member::with(['user', 'membership'])->get());
    });

    Route::get('/api/admin/memberships', function () {
        return response()->json(\App\Models\Membership::with('member.user')->latest()->get());
    });

    Route::get('/api/admin/workouts', function () {
        return response()->json(\App\Models\WorkoutPlan::latest()->get());
    });

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