<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\BillingPageKasirController;
use App\Http\Controllers\BillingPackageController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\LaporanPageKasirController;
use App\Http\Controllers\ShiftController;

// Redirect berdasarkan role
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match (strtolower($user->role->name ?? '')) {
            'kasir' => redirect('/kasir/dashboard'),
            'admin' => redirect('/admin/dashboard'),
            default => redirect('/login'),
        };
    }
    return redirect('/login');
});

// ======================= AUTH ROUTES =======================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

// ======================= KASIR ROUTES =======================
Route::get('/get-server-time', function () {
    return response()->json([
        'timestamp' => now()->format('Y-m-d H:i:s.u'),
        'timezone' => config('app.timezone')
    ]);
})->name('get-server-time');

Route::prefix('kasir')->middleware('auth')->group(function () {
    // Shift Management Routes
    Route::get('/shift/check-status', [ShiftController::class, 'checkShiftStatus'])->name('shift.check');
    Route::post('/shift/start', [ShiftController::class, 'startShift'])->name('shift.start');
    Route::post('/shift/end', [ShiftController::class, 'endShift'])->name('shift.end');

    // Existing Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('kasir.dashboard');
    Route::get('/billing', [BillingPageKasirController::class, 'Devices'])->name('kasir.billing');
    Route::get('/laporan', [LaporanPageKasirController::class, 'index'])->name('kasir.laporan');
    Route::get('/paket-billing', [BillingPageKasirController::class, 'PaketBillingKasir'])->name('paket.billing');
    Route::post('/billing/start', [BillingPageKasirController::class, 'startBilling'])->name('billing.start');
    Route::post('/billing/add', [BillingPageKasirController::class, 'addBilling'])->name('billing.add');
    Route::post('/billing/update-status', [BillingPageKasirController::class, 'updateDeviceStatus'])->name('billing.update-status');
    Route::post('/billing/finish', [BillingPageKasirController::class, 'finishBilling'])->name('billing.finish');
    Route::post('/billing/restart', [BillingPageKasirController::class, 'restartBilling'])->name('billing.restart');
    Route::get('/print-receipt/{transactionId}', [LaporanPageKasirController::class, 'printReceipt'])->name('kasir.print.receipt');
});

// ======================= ADMIN ROUTES =======================
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
});

// ======================= BILLING PACKAGE ROUTES =======================
Route::middleware('auth')->resource('billing-packages', BillingPackageController::class);

// ======================= LOG ACTIVITY ROUTES =======================
Route::prefix('log-activity')->middleware('auth:sanctum')->controller(LogActivityController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/', 'store');
});

// Shift Management Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/shift/status', [ShiftController::class, 'checkShiftStatus']);
    Route::post('/shift/start', [ShiftController::class, 'startShift'])->middleware('web');
    Route::post('/shift/end', [ShiftController::class, 'endShift'])->middleware('web');
});

// =======================================================================================
Route::get('/current-time', function () {
    return response()->json([
        'time' => now()->translatedFormat('l, d F Y H:i') // Waktu dalam format yang lebih enak dibaca
    ]);
});
