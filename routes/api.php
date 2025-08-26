<?php

use App\Http\Controllers\WebDevController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangLombaController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\MlMatchController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\MedpartController;
use App\Http\Controllers\DaftarSeminar;
use App\Http\Controllers\AspekPenilaianController;
use App\Http\Controllers\PenilaianController;



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


Route::prefix('webdev-progress')->group(function () {
    Route::get('/', [WebDevController::class, 'index']);
    Route::get('/{id}', [WebDevController::class, 'show']);
    Route::post('/', [WebDevController::class, 'store']);
});

Route::prefix('seminar')->group(function () {
    Route::get('/', [SeminarController::class, 'index']);
});


Route::prefix('sponsor')->group(function () {
    Route::get('/', [SponsorController::class, 'getAllSponsorsByType']);
    Route::get('/{id}', [SponsorController::class, 'getSponsorById']);
});

Route::prefix('medpart')->group(function () {
    Route::get('/', [MedpartController::class, 'getAllMedpartByType']);
    Route::get('/{id}', [MedpartController::class, 'getMedpartById']);
});

Route::prefix('daftarseminar')->group(function () {
    Route::get('/', [DaftarSeminar::class, 'index']);
    Route::get('/{kode_absen}', [DaftarSeminar::class, 'showByAbsen']);
    Route::post('/', [DaftarSeminar::class, 'createDaftarSeminar']);
});

Route::prefix('aspek-penilaian')->group(function () {
    Route::get('/cabang/{id}', [AspekPenilaianController::class, 'aspekPenilaianByCabangLomba']);
});

// Penilaian
Route::get('/penilaian/karya/{progressId}/juri/{juriId}', [PenilaianController::class, 'getScoresByJuri']);
// Juri Only
Route::post('/penilaian', [PenilaianController::class, 'store'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/juri', function () {
    return auth('juri')->user();
});
