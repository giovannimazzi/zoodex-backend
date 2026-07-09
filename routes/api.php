<?php

use App\Http\Controllers\Api\AnimalController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\TaxonomyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

Route::get('/', [HomeController::class, 'index']);

Route::get('/settings', [SettingsController::class, 'index']);

Route::get('/animals', [AnimalController::class, 'index']);
Route::get('/animals/{slug}', [AnimalController::class, 'show']);

Route::get('/taxonomies', [TaxonomyController::class, 'index']);