<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DataPemilihController;
use App\Http\Controllers\admin\KandidatController;
use App\Http\Controllers\admin\ManagementUser;
use App\Http\Controllers\AuthentifikasiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\siswa\RiwayatVotingController;
use App\Http\Controllers\siswa\VotingController;
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
            Route::post('/', [KandidatController::class, 'post'])->name('admin.kandidat.post');
            Route::put('{id}', [KandidatController::class, 'edit'])->name('admin.kandidat.edit');
            Route::delete('{id}', [KandidatController::class, 'delete'])->name('admin.kandidat.delete');
        });
        Route::get('data-pemilih', [DataPemilihController::class, 'show'])->name('admin.data-pemilih.store');
        Route::prefix('user')->group(function () {
            Route::get('/', [ManagementUser::class, 'show'])->name('admin.user.store');
            Route::prefix('upload')->group(function () {
                Route::post('/', [ManagementUser::class, 'post'])->name('admin.user.post');
                Route::post('excel', [ManagementUser::class, 'postExcel'])->name('admin.user.excel');
            });
            Route::put('{id}', [ManagementUser::class, 'edit'])->name('admin.user.edit');
            Route::delete('{id}', [ManagementUser::class, 'delete'])->name('admin.user.delete');
        });
    });
});
Route::middleware('auth')->group(function () {
    Route::put('{id}', [Controller::class, 'editProfile'])->name('profile.edit');
    Route::get('/logout', [AuthentifikasiController::class, 'logout'])->name('logout');
    Route::prefix('siswa')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.siswa');
        Route::prefix('voting')->group(function () {
            Route::get('/', [VotingController::class, 'show'])->name('siswa.voting.store');
            Route::post('{id}', [VotingController::class, 'post'])->name('siswa.voting.edit');
        });
        Route::get('riwayat-voting', [RiwayatVotingController::class, 'show'])->name('siswa.riwayat-voting.store');
    });
});
