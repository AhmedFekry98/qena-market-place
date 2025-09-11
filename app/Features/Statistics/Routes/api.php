<?php

use Illuminate\Support\Facades\Route;
use App\Features\Statistics\Controllers\StatisticsController;

Route::middleware(['auth:sanctum', 'role:admin'])->group(function() {
    Route::prefix("statistics")->group(function() {

        // Admin-only statistics - single endpoint for all dashboard data
        Route::get('/dashboard', [StatisticsController::class, 'dashboard']);

    });
});
