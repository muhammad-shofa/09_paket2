<?php

use App\Http\Controllers\AreaParkirController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/track', [\App\Http\Controllers\HomeController::class, 'track'])->name('track');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\LogAktivitasController;

Route::middleware('auth')->group(function () {
    // Role-based Dashboards
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

    Route::get('/dashboard/petugas', [DashboardController::class, 'petugas'])->name('dashboard.petugas');

    Route::get('/dashboard/owner', [\App\Http\Controllers\OwnerController::class, 'dashboard'])->name('dashboard.owner');
    Route::get('/owner/rekap', [\App\Http\Controllers\OwnerController::class, 'rekap'])->name('rekap.owner');
    Route::get('/chatbot/context', [\App\Http\Controllers\ChatbotController::class, 'context'])->name('chatbot.context');

    // Resources
    Route::resource("/user", UserController::class);
    Route::resource("area", AreaParkirController::class);
    Route::resource("tarif", TarifController::class);
    Route::resource("kendaraan", KendaraanController::class);

    // Transaksi Routes
    Route::get('/transaksi/cetak/{id}', [\App\Http\Controllers\TransaksiController::class, 'cetakStruk'])->name('transaksi.cetak');
    Route::get('/transaksi/karcis/{id}', [\App\Http\Controllers\TransaksiController::class, 'cetakKarcis'])->name('transaksi.karcis');
    Route::resource('transaksi', \App\Http\Controllers\TransaksiController::class);

    // Log Route (Read Only)
    Route::get('log', [LogAktivitasController::class, 'index'])->name('log.index');
});
