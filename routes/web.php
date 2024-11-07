<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DataPemilihController;
use App\Http\Controllers\admin\KandidatController;
use App\Http\Controllers\AuthentifikasiController;
use App\Http\Middleware\SesiFalse;
use Illuminate\Support\Facades\Route;

Route::middleware(SesiFalse::class)->group(function () {
    Route::get('/', [AuthentifikasiController::class, 'login'])->name('login');
    Route::post('/', [AuthentifikasiController::class, 'verif'])->name('login.verif');
});

Route::middleware('role:admin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.admin');
        Route::prefix('kandidat')->group(function () {
            Route::get('/', [KandidatController::class, 'show'])->name('admin.kandidat.store');
            Route::post('/', [KandidatController::class, 'post']);
            Route::put('{id}', [KandidatController::class, 'edit']);
            Route::delete('{id}', [KandidatController::class, 'delete']);
        });
        Route::prefix('data-pemilih')->group(function () {
            Route::get('/', [DataPemilihController::class, 'show'])->name('admin.data-pemilih.store');
        });
    });
});
Route::get('/logout', [AuthentifikasiController::class, 'logout'])->name('logout');
