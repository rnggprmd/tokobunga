<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    if ($request->user() && $request->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('welcome');
})->name('home');

use App\Http\Controllers\AuthController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store']);
});

Route::post('logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
