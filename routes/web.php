<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index'])->name('home');

Route::get('principal', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('urmarite', [\App\Http\Controllers\BookmarkController::class, 'index'])->middleware(['auth', 'verified'])->name('bookmarks');
Route::post('urmarite', [\App\Http\Controllers\BookmarkController::class, 'store'])->middleware(['auth', 'verified'])->name('bookmarks');

Route::get('grafic', function () {
    return Inertia::render('Chart');
})->middleware(['auth', 'verified'])->name('chart');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
