<?php

use App\Features\SystemManagements\Controllers\GeneralSettingController;
use App\Features\SystemManagements\Controllers\PermissionController;
use App\Features\SystemManagements\Controllers\PolicyController;
use App\Features\SystemManagements\Controllers\RoleController;
use App\Features\SystemManagements\Controllers\RolePermissionController;
use App\Features\SystemManagements\Controllers\TermConditionController;
use App\Features\SystemManagements\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix("system-managements")->group(function() {

        Route::prefix("roles")->group(function() {
            Route::get('/', [RoleController::class, 'index']);
            Route::post('/', [RoleController::class, 'store']);
            Route::get('/{id}', [RoleController::class, 'show']);
            Route::put('/{id}', [RoleController::class, 'update']);
            Route::delete('/{id}', [RoleController::class, 'destroy']);
        });

        Route::prefix("permissions")->group(function() {
            Route::get('/', [PermissionController::class, 'index']);
            Route::get('/{id}', [PermissionController::class, 'show']);
            // Route::post('/', [PermissionController::class, 'store']);
            // Route::put('/{id}', [PermissionController::class, 'update']);
            // Route::delete('/{id}', [PermissionController::class, 'destroy']);
        });

        Route::prefix("user-roles")->group(function() {
            Route::post('/', [UserRoleController::class, 'store']);
        });

        Route::prefix("role-permissions")->group(function() {
            Route::post('/', [RolePermissionController::class, 'store']);
        });

        Route::prefix("general-settings")->group(function() {
            Route::get('/', [GeneralSettingController::class, 'index']);
            Route::get('/{id}', [GeneralSettingController::class, 'show']);
            Route::get('/key/{key}', [GeneralSettingController::class, 'getByKey']);

            Route::middleware('role:admin')->group(function() {
                Route::post('/', [GeneralSettingController::class, 'store']);
                Route::put('/{id}', [GeneralSettingController::class, 'update']);
                Route::delete('/{id}', [GeneralSettingController::class, 'destroy']);
                Route::put('/key/{key}', [GeneralSettingController::class, 'updateByKey']);
            });

        });
    });

    // policy
    Route::prefix("policies")->group(function() {

        Route::get('/', [PolicyController::class, 'index']);
        Route::get('/{id}', [PolicyController::class, 'show']);
        Route::get('/key/{key}', [PolicyController::class, 'getByKey']);

        Route::middleware('role:admin')->group(function() {
            Route::post('/', [PolicyController::class, 'store']);
            Route::put('/{id}', [PolicyController::class, 'update']);
            Route::delete('/{id}', [PolicyController::class, 'destroy']);
        });
    });

    // term condition
    Route::prefix("term-conditions")->group(function() {

        Route::get('/', [TermConditionController::class, 'index']);
        Route::get('/{id}', [TermConditionController::class, 'show']);
        Route::get('/key/{key}', [TermConditionController::class, 'getByKey']);

        Route::middleware('role:admin')->group(function() {
            Route::post('/', [TermConditionController::class, 'store']);
            Route::put('/{id}', [TermConditionController::class, 'update']);
            Route::delete('/{id}', [TermConditionController::class, 'destroy']);
        });
    });
});
