<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('chart', function () {
    return Inertia::render('Chart');
})->middleware(['auth', 'verified'])->name('chart');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
