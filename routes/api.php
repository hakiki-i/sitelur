
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiLoginController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\ProduksiController;

// 🔓 LOGIN (TANPA TOKEN)
Route::post('/login', [ApiLoginController::class, 'login']);
Route::get('/test', function () {
    return response()->json(['status' => 'API OK']);
});
// 🔐 ROUTE YANG BUTUH LOGIN
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/kandang', [KandangController::class, 'apiIndex']);
    Route::post('/input-produksi', [ProduksiController::class, 'apiStore']);
});

