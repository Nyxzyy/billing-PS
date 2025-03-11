<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogActivityController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/log-activity', [LogActivityController::class, 'index']);     
    Route::get('/log-activity/{id}', [LogActivityController::class, 'show']); 
    Route::post('/log-activity', [LogActivityController::class, 'store']);   
});
