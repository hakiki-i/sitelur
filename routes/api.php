<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiLoginController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\DashboardController;

// LOGIN
Route::post('/login', [ApiLoginController::class, 'login']);

// TEST
Route::get('/test', function () {
    return response()->json([
        'status' => true,
        'message' => 'API OK'
    ]);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'apiIndex']);
    // ...route lain
});
// ROUTE LOGIN
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'apiIndex']);

    Route::get('/kandang', [KandangController::class, 'apiIndex']);

    Route::post('/produksi', [ProduksiController::class, 'apiStore']);

});