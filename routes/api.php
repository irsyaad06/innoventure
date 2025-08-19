<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangLombaController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\MlMatchController;

Route::prefix('cabang-lomba')->group(function () {
    Route::get('/', [CabangLombaController::class, 'index']);
    Route::get('/{id}', [CabangLombaController::class, 'show']);
});

Route::prefix('instansi')->group(function () {
    Route::get('/', [InstansiController::class, 'index']);
    Route::get('/{id}', [InstansiController::class, 'show']);
});

Route::prefix('tim')->group(function () {
    Route::get('/', [TimController::class, 'index']);
    Route::get('/{id}', [TimController::class, 'show']);
});

Route::prefix('ml-match')->group(function () {
    Route::get('/', [MlMatchController::class, 'index']);
    Route::get('/{id}', [MlMatchController::class, 'show']);
});
