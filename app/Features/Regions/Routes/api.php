<?php

use Illuminate\Support\Facades\Route;
use App\Features\Regions\Controllers\CityController;
use App\Features\Regions\Controllers\AreaController;


Route::prefix("regions")->group(function() {

    // Cities Routes
    Route::prefix("cities")->group(function() {
        Route::get('/', [CityController::class, 'index']);
        Route::get('/{id}', [CityController::class, 'show']);
        Route::get('/{cityId}/areas', [CityController::class, 'areas']);
        Route::middleware('role:admin')->group(function() {
            Route::post('/', [CityController::class, 'store']);
            Route::put('/{id}', [CityController::class, 'update']);
            Route::delete('/{id}', [CityController::class, 'destroy']);
        });
    });

    // Areas Routes
    Route::prefix("areas")->group(function() {
        Route::get('/', [AreaController::class, 'index']);
        Route::get('/{id}', [AreaController::class, 'show']);
        Route::middleware('role:admin')->group(function() {
            Route::post('/', [AreaController::class, 'store']);
            Route::put('/{id}', [AreaController::class, 'update']);
            Route::delete('/{id}', [AreaController::class, 'destroy']);
        });
    });

});

