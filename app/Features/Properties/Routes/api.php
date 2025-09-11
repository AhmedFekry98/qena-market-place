<?php

use Illuminate\Support\Facades\Route;
use App\Features\Properties\Controllers\PropertyTypeController;
use App\Features\Properties\Controllers\PropertyController;
// use App\Features\Properties\Controllers\PropertyImageController;

// Property Types Routes

Route::middleware('auth:sanctum')->group(function() {

    Route::prefix("property-types")->group(function() {
        Route::get('/', [PropertyTypeController::class, 'index']);
        Route::get('/{id}', [PropertyTypeController::class, 'show']);
        Route::middleware('role:admin')->group(function() {
            Route::post('/', [PropertyTypeController::class, 'store']);
            Route::put('/{id}', [PropertyTypeController::class, 'update']);
            Route::delete('/{id}', [PropertyTypeController::class, 'destroy']);
            Route::put('/{id}/change-status', [PropertyTypeController::class, 'changeStatus']);
        });
    });

    // Properties Routes
    Route::prefix("properties")->group(function() {
        Route::get('/', [PropertyController::class, 'index']);
        Route::get('/{id}', [PropertyController::class, 'show']);
        Route::middleware('role:admin')->group(function() {
            Route::post('/', [PropertyController::class, 'store']);
            Route::put('/{id}', [PropertyController::class, 'update']);
            Route::delete('/{id}', [PropertyController::class, 'destroy']);
            Route::put('/{id}/change-status', [PropertyController::class, 'changeStatus']);
        });
    });
});


