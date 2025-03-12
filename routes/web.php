<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\BillingPackageController;

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
Route::prefix('kasir')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('kasir.dashboard');
    Route::view('/billing', 'kasir.billing')->name('kasir.billing');
    Route::view('/laporan', 'kasir.laporan')->name('kasir.laporan');
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

// =======================================================================================
Route::get('/current-time', function () {
    return response()->json([
        'time' => now()->translatedFormat('l, d F Y H:i:s') // Waktu dalam format yang lebih enak dibaca
    ]);
});
