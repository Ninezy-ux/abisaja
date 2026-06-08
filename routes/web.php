<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/profil', [HomeController::class, 'profil'])->name('profil');

Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

Route::redirect('/profile', '/profil');
Route::redirect('/contact', '/kontak');

// Route Campaign (resource: index, create, store, show, edit, update, destroy)
Route::resource('campaign', CampaignController::class);

// Route Donation (resource: index, create, store, show, destroy)
Route::resource('donation', DonationController::class)
     ->except(['edit', 'update']); // Donasi tidak perlu diedit
