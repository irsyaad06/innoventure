<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::fallback(function () {
    return view('welcome');
});
