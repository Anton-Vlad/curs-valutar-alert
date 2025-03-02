<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('chart', function () {
    return Inertia::render('Chart');
})->middleware(['auth', 'verified'])->name('chart');

Route::get('bookmarks', function () {
    return Inertia::render('Bookmarks');
})->middleware(['auth', 'verified'])->name('bookmarks');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
