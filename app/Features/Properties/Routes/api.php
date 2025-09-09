<?php

use Illuminate\Support\Facades\Route;
use App\Features\Properties\Controllers\PropertyTypeController;
use App\Features\Properties\Controllers\PropertyController;
use App\Features\Properties\Controllers\PropertyTransactionController;
use App\Features\Properties\Controllers\PropertyImageController;

// Property Types Routes
Route::prefix("property-types")->group(function() {
    Route::get('/', [PropertyTypeController::class, 'index']);
    Route::post('/', [PropertyTypeController::class, 'store']);
    Route::get('/{id}', [PropertyTypeController::class, 'show']);
    Route::put('/{id}', [PropertyTypeController::class, 'update']);
    Route::delete('/{id}', [PropertyTypeController::class, 'destroy']);
});

// Properties Routes
Route::prefix("properties")->group(function() {
    Route::get('/', [PropertyController::class, 'index']);
    Route::post('/', [PropertyController::class, 'store']);
    Route::get('/my-properties', [PropertyController::class, 'myProperties']);
    Route::get('/{id}', [PropertyController::class, 'show']);
    Route::put('/{id}', [PropertyController::class, 'update']);
    Route::delete('/{id}', [PropertyController::class, 'destroy']);

    // Property Images Routes (Media Library)
    Route::get('/{id}/images', [PropertyImageController::class, 'index']);
    Route::post('/{id}/images', [PropertyImageController::class, 'store']);
    Route::delete('/{id}/images/{mediaId}', [PropertyImageController::class, 'destroy']);
    Route::put('/{id}/images/{mediaId}/primary', [PropertyImageController::class, 'setPrimary']);
});


