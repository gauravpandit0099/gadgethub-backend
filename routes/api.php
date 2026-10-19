<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/* common login */
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

/* authentication api */
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile'])->name('user-profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('logout-all');

    /* admin api */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

    });

    /* user api */
    Route::prefix('user')->name('user.')->middleware('role:user')->group(function () {

    });
});