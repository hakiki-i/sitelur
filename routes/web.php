
<?php
use App\Http\Controllers\AyamController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\Auth\ApiLoginController;


Route::get('/', function () {
    return view('landing');
});

use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
    // Route::resource('kandang', KandangController::class);
});


use App\Http\Controllers\ProduksiController;
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('kandang', KandangController::class);
    Route::resource('pegawai', App\Http\Controllers\PegawaiController::class);
    Route::resource('ayam', AyamController::class);
    Route::get('/produksi', [ProduksiController::class, 'index'])->name('produksi.index');
    Route::post('/produksi/{id}/validasi', [ProduksiController::class, 'validasi'])->name('produksi.validasi');
    Route::post('/produksi/{id}/reject', [ProduksiController::class, 'reject'])->name('produksi.reject');
    Route::resource('harga_telur', App\Http\Controllers\HargaTelurController::class);
    Route::resource('penjualan', App\Http\Controllers\PenjualanController::class);
    Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/{type}', [App\Http\Controllers\LaporanController::class, 'export'])->name('laporan.export');
});
// API sementara (tanpa prefix api)
Route::post('/api/login', [ApiLoginController::class, 'login']);
Route::get('/api/kandang', [KandangController::class, 'apiIndex']);
Route::post('/api/produksi', [ProduksiController::class, 'apiStore']);
require __DIR__.'/auth.php';
