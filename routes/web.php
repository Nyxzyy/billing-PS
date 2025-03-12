<?php

use Illuminate\Support\Facades\Route;

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
