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
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\LaporanKendalaController;
use App\Http\Controllers\LaporanKasirController;
use App\Http\Controllers\LaporanDeviceController;

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
        Route::get('/device/search', 'search')->name('admin.device.search');
        Route::post('/devices', 'store')->name('admin.devices.store');
        Route::put('/devices/{device}', 'update')->name('admin.devices.update');
        Route::delete('/devices/{device}', 'destroy')->name('admin.devices.destroy');
    });

    // User Management
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('/manage-users', [UserManagementController::class, 'index'])->name('admin.manageUser');
        Route::get('/manage-users/search', [UserManagementController::class, 'search'])->name('admin.manageUser.search');
        Route::post('/manage-users', [UserManagementController::class, 'store'])->name('admin.manageUser.store');
        Route::put('/manage-users/{user}', [UserManagementController::class, 'update'])->name('admin.manageUser.update');
        Route::delete('/manage-users/{user}', [UserManagementController::class, 'destroy'])->name('admin.manageUser.destroy');
    });
    
    // Billing Package Management
    Route::prefix('billingPackages')->group(function () {
        Route::get('/', [BillingPackageController::class, 'index'])->name('admin.paketBilling');
        Route::get('/billing-packages/search', [BillingPackageController::class, 'search'])->name('billing-packages.search');
        Route::post('/billing-packages', [BillingPackageController::class, 'store'])->name('billing-packages.store');
        Route::get('/billing-packages/{id}/edit', [BillingPackageController::class, 'edit'])->name('billing-packages.edit');
        Route::put('/billing-packages/{id}', [BillingPackageController::class, 'update'])->name('billing-packages.update');
        Route::delete('/billing-packages/{id}', [BillingPackageController::class, 'destroy'])->name('billing-packages.destroy');
    });
    
    // Open Billing Package Management
    Route::prefix('openBilling')->name('admin.openBilling.')->group(function () {
        Route::get('/', [OpenBillingController::class, 'index'])->name('index');
        Route::post('/update', [OpenBillingController::class, 'update'])->name('update');
        Route::post('/storePromo', [OpenBillingController::class, 'storePromo'])->name('storePromo');
        Route::put('/updatePromo/{id}', [OpenBillingController::class, 'updatePromo'])->name('updatePromo');
        Route::delete('/deletePromo/{id}', [OpenBillingController::class, 'deletePromo'])->name('deletePromo');
    });

    // Laporan Kendala Management 
    Route::controller(LaporanKendalaController::class)->group(function () {
        Route::get('/laporan-kendala', 'index')->name('admin.laporan-kendala');
        Route::get('/laporan-kendala/download', 'downloadPdf')->name('admin.laporan-kendala.download-pdf');
        Route::get('/laporan-kendala/search', [LaporanKendalaController::class, 'search'])->name('admin.laporan-kendala.search');
        Route::get('/laporan-kendala/filterbydate', [LaporanKendalaController::class, 'filterByDate'])->name('admin.laporan-kendala.filterByDate');
    });

    // Laporan Kasir
    Route::get('/laporan-kasir', [LaporanKasirController::class, 'index'])->name('admin.laporanKasir');
    Route::get('/laporan-kasir/download', [LaporanKasirController::class, 'downloadPdf'])->name('admin.laporan-kasir.download-pdf');
    Route::get('/laporan-kasir/search', [LaporanKasirController::class, 'search'])->name('admin.laporan-kasir.search');
    Route::get('/laporan-kasir/filterbydate', [LaporanKasirController::class, 'filterByDate'])->name('admin.laporan-kasir.filterByDate');
    Route::get('/laporan-kasir/filter-by-cashier', [LaporanKasirController::class, 'filterByCashier'])->name('admin.laporan-kasir.filterByCashier');
    
    // Laporan Transaksi
    Route::get('/laporan-transaksi', [LaporanTransaksiController::class, 'index'])->name('admin.laporanTransaksi');
    Route::get('/laporan-transaksi/download', [LaporanTransaksiController::class, 'download'])->name('admin.laporanTransaksi.download');
    
    // Laporan Perangkat
    Route::get('/laporan-device', [LaporanDeviceController::class, 'index'])->name('admin.laporanDevice');
    Route::get('/laporan-device/download', [LaporanDeviceController::class, 'downloadPdf'])->name('admin.laporan-device.download-pdf');
    Route::get('/laporan-device/search', [LaporanDeviceController::class, 'search'])->name('admin.laporan-device.search');
    Route::get('/laporan-device/filterbydate', [LaporanDeviceController::class, 'filterByDate'])->name('admin.laporan-device.filterByDate');
    Route::get('/laporan-device/filter-by-device', [LaporanDeviceController::class, 'filterByDevice'])->name('admin.laporan-device.filterByDevice');
});

// ======================= LOG ACTIVITY ROUTES =======================
Route::prefix('log-activity')->middleware('auth')->controller(LogActivityController::class)->group(function () {
    Route::get('/', 'index')->name('log.index');
    Route::get('/{id}', 'show')->name('log.show');
    Route::post('/', 'store')->name('log.store');
    Route::get('/', 'adminIndex')->name('admin.logActivity');
});
