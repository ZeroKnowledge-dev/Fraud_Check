<?php

use App\Http\Controllers\EntityController;
use App\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
	return $request->user();
})->middleware('auth:sanctum');

Route::post('/check-fraud-or-legit', [PublicController::class, 'checkFraudOrLegit']);

Route::post('/report', [EntityController::class, 'createEntity'])->name('report.store');

Route::post('/verify-up', [EntityController::class, 'increaseVerifyCount'])->name('verify.up');
Route::post('/verify-down', [EntityController::class, 'decreaseVerifyCount'])->name('verify.down');
