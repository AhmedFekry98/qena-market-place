<?php

use Illuminate\Support\Facades\Route;
use App\Features\Properties\Controllers\PropertyTypeController;
use App\Features\Properties\Controllers\PropertyController;
use App\Features\Properties\Controllers\PropertyTransactionController;
// use App\Features\Properties\Controllers\PropertyImageController;

// Property Types Routes

Route::middleware('auth:sanctum')->group(function() {

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
        Route::get('/my-marketing-properties', [PropertyController::class, 'myMarketingProperties']);
        Route::get('/{id}', [PropertyController::class, 'show']);
        Route::put('/{id}', [PropertyController::class, 'update']);
        Route::delete('/{id}', [PropertyController::class, 'destroy']);

    });
});


