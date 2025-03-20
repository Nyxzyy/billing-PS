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
use App\Http\Controllers\KendalaController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\OpenBillingController;
use App\Http\Controllers\DeviceManagementController;
use App\Http\Controllers\UserManagementController;

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

// ======================= GLOBAL ROUTES =======================
// Server time route - accessible to all authenticated users
Route::middleware('auth')->get('/server-time', function() {
    return response()->json([
        'timestamp' => now()->format('Y-m-d H:i:s.u'),
        'timezone' => config('app.timezone')
    ]);
})->name('server.time');

// ======================= KASIR ROUTES =======================
Route::prefix('kasir')->middleware(['auth', 'role:kasir'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('kasir.dashboard');
    
    // Billing Management
    Route::controller(BillingPageKasirController::class)->group(function () {
        Route::get('/billing', 'Devices')->name('kasir.billing');
        Route::get('/paket-billing', 'PaketBillingKasir')->name('kasir.paket-billing');
        Route::post('/billing/start', 'startBilling')->name('billing.start');
        Route::post('/billing/add', 'addBilling')->name('billing.add');
        Route::post('/billing/finish', 'finishBilling')->name('billing.finish');
        Route::post('/billing/restart', 'restartBilling')->name('billing.restart');
        Route::post('/billing/update-status', 'updateDeviceStatus')->name('billing.update-status');
    });
    
    // Shift Management
    Route::controller(ShiftController::class)->group(function () {
        Route::get('/shift/check-status', 'checkShiftStatus')->name('shift.check');
        Route::post('/shift/start', 'startShift')->name('shift.start');
        Route::post('/shift/end', 'endShift')->name('shift.end');
    });
    
    // Kendala Management
    Route::controller(KendalaController::class)->prefix('kendala')->name('kendala.')->group(function () {
        Route::post('/report', 'store')->name('report');
        Route::get('/{deviceId}/latest', 'getLatest')->name('latest');
        Route::post('/resolve', 'resolve')->name('resolve');
    });
    
    // Laporan & Receipt
    Route::controller(LaporanPageKasirController::class)->group(function () {
        Route::get('/laporan', 'index')->name('kasir.laporan');
        Route::get('/print-receipt/{transactionId}', 'printReceipt')->name('print.receipt');
    });
});

// ======================= ADMIN ROUTES =======================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/current-time', [DashboardAdminController::class, 'getCurrentTime']);
    Route::get('/dashboard-stats', [DashboardAdminController::class, 'getDashboardStats']);
    Route::post('/chart-data', [DashboardAdminController::class, 'updateChartData'])->name('admin.chart-data');
    
    // Device Management
    Route::controller(DeviceManagementController::class)->group(function () {
        Route::get('/manage-perangkat', 'index')->name('admin.managePerangkat');
        Route::post('/devices', 'store')->name('admin.devices.store');
        Route::put('/devices/{device}', 'update')->name('admin.devices.update');
        Route::delete('/devices/{device}', 'destroy')->name('admin.devices.destroy');
    });

    // User Management
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('/manage-users', 'index')->name('admin.manageUser');
        Route::post('/users', 'store')->name('admin.users.store');
        Route::put('/users/{user}', 'update')->name('admin.users.update');
        Route::delete('/users/{user}', 'destroy')->name('admin.users.destroy');
    });
    
    // Billing Package Management
    Route::get('/paket-billing', [BillingPackageController::class, 'index'])->name('admin.paketBilling');
    Route::resource('billing-packages', BillingPackageController::class);
    Route::get('/open-billing', [OpenBillingController::class, 'index'])->name('admin.openBilling');
    Route::post('/open-billing', [OpenBillingController::class, 'update'])->name('admin.openBilling.update');
    Route::get('/admin/open-billing', [OpenBillingController::class, 'index'])->name('admin.openBilling.index');
    Route::view('/laporan-device', 'admin.laporan')->name('admin.laporan');
    Route::view('/laporan-kasir', 'admin.laporanKasir')->name('admin.laporanKasir');
    Route::view('/laporan-transaksi', 'admin.laporanTransaksi')->name('admin.laporanTransaksi');
    Route::view('/laporan-kendala', 'admin.laporanKendala')->name('admin.laporanKendala');
    Route::get('/log-activity', [LogActivityController::class, 'adminIndex'])->name('admin.logActivity');
});

// ======================= LOG ACTIVITY ROUTES =======================
Route::prefix('log-activity')->middleware('auth:sanctum')->controller(LogActivityController::class)->group(function () {
    Route::get('/', 'index')->name('log.index');
    Route::get('/{id}', 'show')->name('log.show');
    Route::post('/', 'store')->name('log.store');
});
