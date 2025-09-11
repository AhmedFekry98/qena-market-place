<?php

use App\Features\AuthManagement\Controllers\TokenController;
use App\Features\AuthManagement\Controllers\ChangePasswordController;
use App\Features\AuthManagement\Controllers\ForgotPasswordController;
use App\Features\AuthManagement\Controllers\ResetPasswordController;
use App\Features\AuthManagement\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// login

Route::prefix('login')->group(function () {
    Route::post('/{guard}', [TokenController::class, 'login'])
        ->where('guard', 'admin|customer');
});

// forgot password
Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('forgot-verify-code', [ForgotPasswordController::class, 'forgotVerifyCode']);
// reset password
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->group(function () {
    // logout
    Route::post('logout', [TokenController::class, 'logout']);
    // change password
    Route::put('change-password', [ChangePasswordController::class, 'changePassword']);

    // get auth user profile
    Route::get('auth/profile', [ProfileController::class, 'show']);
    // update auth user profile
    Route::put('auth/profile', [ProfileController::class, 'update']);

    // get auth user properties
    Route::middleware('role:admin')->group(function () {
        Route::get('auth/profiles/agents', [ProfileController::class, 'agents']);
        Route::post('register/agents', [ProfileController::class, 'registerAgent']);
    });
});




