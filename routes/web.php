<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PlaceController as AdminPlaceController;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jelajah', [PlaceController::class, 'index'])->name('places.index');
Route::get('/tempat/{place:place_id}', [PlaceController::class, 'show'])->name('places.show');
Route::post('/tempat/{place}/log', [PlaceController::class, 'logAction'])->name('places.log');

// --- Auth Routes ---
require __DIR__.'/auth.php';

// --- User Dashboard ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/favorit', [PlaceController::class, 'favorites'])->name('places.favorites');
    Route::get('/profil', fn() => view('profile.edit'))->name('profile.edit');
});

// --- Partner Routes ---
Route::middleware(['auth', 'partner'])->prefix('mitra')->name('partner.')->group(function () {
    Route::get('/', [PartnerController::class, 'dashboard'])->name('dashboard');
    Route::get('/tempat/tambah', [PartnerController::class, 'createPlace'])->name('place.create');
    Route::get('/tempat/{place}/edit', [PartnerController::class, 'editPlace'])->name('place.edit');
    Route::get('/promo', [PartnerController::class, 'promos'])->name('promos');
});

// --- Admin Routes ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/tempat', [AdminPlaceController::class, 'index'])->name('places.index');
    Route::get('/ulasan', fn() => view('admin.reviews'))->name('reviews');
    Route::get('/mitra', fn() => view('admin.partners'))->name('partners');
});
