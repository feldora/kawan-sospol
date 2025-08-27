<?php

use Illuminate\Support\Facades\Route;

Route::get('data/konflik', [App\Http\Controllers\Api\DataController::class, 'konflik'])->name('api.data.konflik');
