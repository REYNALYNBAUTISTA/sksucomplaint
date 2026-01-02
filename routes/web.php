<?php

use App\Enums\Roles;
use App\Http\Controllers\AdminComplaintController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfficeAccountController;
use App\Http\Controllers\OfficeComplaintController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| Centralized Dashboard and Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Centralized Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:'.Roles::STUDENT->value])->group(function () {
    Route::get('/complaint/create', [ComplaintController::class, 'create'])->name('complaint.create');
    Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store');
    Route::get('/complaint/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaint.edit');
    Route::patch('/complaint/{complaint}', [ComplaintController::class, 'update'])->name('complaint.update');
    Route::delete('/complaint/{complaint}', [ComplaintController::class, 'destroy'])->name('complaint.destroy');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])
        ->name('complaint.show');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:'.Roles::ADMIN->value.','.Roles::SUPER_ADMIN->value])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        // ====================================================
        // 1. OFFICE MANAGEMENT ROUTES (OfficeAccountController)
        // ====================================================
        Route::controller(OfficeAccountController::class)->group(function () {

            // Combined Creation (Office + User)
            Route::prefix('office-accounts')->name('office-accounts.')->group(function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
            });

            // Standard Management (List, Edit, Delete)
            Route::prefix('offices')->name('offices.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{office}/edit', 'edit')->name('edit');
                Route::put('/{office}', 'update')->name('update');
                Route::delete('/{office}', 'destroy')->name('destroy');
            });

            // Personnel Management (Edit specific user details)
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/{user}/edit', 'editPersonnel')->name('edit');
                Route::put('/{user}', 'updatePersonnel')->name('update');
            });
        });

        // ====================================================
        // 2. COMPLAINT MANAGEMENT ROUTES (AdminComplaintController)
        // ====================================================
        Route::controller(AdminComplaintController::class)->prefix('complaints')->name('complaints.')->group(function () {

            // List all complaints
            Route::get('/', 'index')->name('index');

            // Routing Actions (Assigning an Office)
            Route::get('/{complaint}/assign', 'showAssignmentForm')->name('assign.form');
            Route::post('/{complaint}/assign', 'assignOffice')->name('assign');

            // View Complaint Details
            Route::get('/{complaint}', 'show')->name('show');
        });

    }); // End Admin Group
Route::post('/admin/complaints/{complaint}/notify', [AdminComplaintController::class, 'notifyStudent'])
    ->name('admin.complaints.notify');
/*
|--------------------------------------------------------------------------
| Office Personnel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('office')->middleware(['auth', 'role:'.Roles::OFFICE_PERSONNEL->value])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'officeDashboard'])->name('office.dashboard');

    // ✅ ADD THIS LINE:
    Route::get('/history', [DashboardController::class, 'officeHistory'])->name('office.history');
    Route::get('/complaint/{complaint}', [OfficeComplaintController::class, 'show'])
        ->name('office.complaint.show');
    Route::post('/complaint/{complaint}/process', [OfficeComplaintController::class, 'process'])->name('office.complaint.process');

});

require __DIR__.'/auth.php';
