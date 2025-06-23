<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\MahasiswaController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//    return view('dashboard');
// });

Route::get('/', [DasboardController::class, 'index']);
//Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
//Route::post('/mahasiswa', [MahasiswaController::class, 'store']);
//Route::get('/mahasiswa/create', [MahasiswaController::class, 'create']);
Route::resource('/mahasiswa', MahasiswaController::class);
