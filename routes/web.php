<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/kontak', [HomeController::class, 'kontak']);
Route::get('/profil', [HomeController::class, 'profil']);
