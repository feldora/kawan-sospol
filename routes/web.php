<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/peta-sebaran', [App\Http\Controllers\PetaSebaranController::class, 'index'])->name('peta-sebaran.index');

Route::get('/lapor-kawan', [App\Http\Controllers\LaporKawanController::class, 'create'])->name('lapor-kawan.create');

// laporan
Route::post('/laporan', [App\Http\Controllers\LaporanController::class, 'store'])->name('laporan.store');


Route::get('api/data/konflik', [App\Http\Controllers\api\DataController::class, 'konflik'])->name('api.data.konflik');
Route::get('api/data/potensiKonflik', [App\Http\Controllers\api\DataController::class, 'potensiKonflik'])->name('api.data.potensiKonflik');
Route::get('api/data/konflik-kabupaten', [App\Http\Controllers\api\DataController::class, 'konflikPerKabupaten'])->name('api.data.konflikPerKabupaten');
Route::get('api/data/konflik-desa-detail/{desaId?}', [App\Http\Controllers\api\DataController::class, 'detailKonflikPerDesa'])->name('api.data.detailKonflikPerDesa');

Route::get('api/kecamatan', [App\Http\Controllers\api\WilayahController::class, 'getKecamatan']);
Route::get('api/desa', [App\Http\Controllers\api\WilayahController::class, 'getDesa']);
Route::get('api/kabupaten', [App\Http\Controllers\api\WilayahController::class, 'getKabupaten']);
Route::get('api/provinsi', [p\Http\Controllers\api\WilayahController::class, 'getProvinsi']);
