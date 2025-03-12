<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\BillingPackageController;

Route::get('/', function () {
    return view('login');
});

Route::prefix('kasir')->group(function () {
    Route::get('/dashboard', function () {
        return view('kasir.dashboard');
    })->name('kasir.dashboard');

    Route::get('/billing', function () {
        return view('kasir.billing');
    })->name('kasir.billing');

    Route::get('/laporan', function () {
        return view('kasir.laporan');
    })->name('kasir.laporan');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/log-activity', [LogActivityController::class, 'index']);     
    Route::get('/log-activity/{id}', [LogActivityController::class, 'show']); 
    Route::post('/log-activity', [LogActivityController::class, 'store']);   
});

Route::resource('billing-packages', BillingPackageController::class);
