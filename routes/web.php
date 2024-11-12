<?php

use App\Livewire\BookTracker;
use App\Livewire\Wishlist;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('/book-tracker', BookTracker::class)
    ->middleware(['auth', 'verified'])
    ->name('Book Tracker');

Route::get('/wish-list', Wishlist::class)
    ->middleware(['auth', 'verified'])
    ->name('wish list');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
