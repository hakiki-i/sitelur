<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiLoginController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\DashboardController;

// ======================
// PUBLIC ROUTE
// ======================

// LOGIN
Route::post('/login', [ApiLoginController::class, 'login']);

// TEST API
Route::get('/test', function () {
    return response()->json([
        'status' => true,
        'message' => 'API OK'
    ]);
});

// ======================
// PROTECTED ROUTE
// ======================
Route::middleware('auth:sanctum')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'apiIndex']);

    // KANDANG
    Route::get('/kandang', [KandangController::class, 'apiIndex']);

    // PRODUKSI
    Route::get('/produksi', [ProduksiController::class, 'apiIndex']);
    Route::post('/produksi', [ProduksiController::class, 'apiStore']);
});