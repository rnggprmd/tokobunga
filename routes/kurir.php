<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kurir\KurirDashboardController;
use App\Http\Controllers\Kurir\KurirShippingController;

Route::middleware(['auth', 'kurir'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('kurir.dashboard');
    });
    Route::get('/dashboard', [KurirDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengiriman', [KurirShippingController::class, 'index'])->name('pengiriman.index');
    Route::get('/riwayat', [KurirShippingController::class, 'history'])->name('pengiriman.history');
    Route::patch('/pengiriman/{pengiriman}/selesai', [KurirShippingController::class, 'selesai'])->name('pengiriman.selesai');
    Route::patch('/pengiriman/{pengiriman}/proses', [KurirShippingController::class, 'proses'])->name('pengiriman.proses');
    Route::post('/location/update', [KurirShippingController::class, 'updateLocation'])->name('location.update');
});
