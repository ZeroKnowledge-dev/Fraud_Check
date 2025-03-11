<?php

use App\Http\Controllers\EntityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([
	'auth:sanctum',
	config('jetstream.auth_session'),
	'verified',
])->group(function () {
	Route::get('/dashboard', function () {
		return Inertia::render('Dashboard');
	})->name('dashboard');
});

// web.php
Route::get('/', [HomeController::class, 'index'])->name('home');

// Search routes
Route::get('/search/{validity}/{type}', [SearchController::class, 'index'])->name('search');

// Report routes
Route::get('/report/{validity}/{type}', [EntityController::class, 'index'])->name('report');
