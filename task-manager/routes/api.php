<?php

use App\Http\Controllers\Api\{AuthController, StaffController, TaskController};
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Admin only
        Route::middleware('role:admin')->group(function () {
            Route::apiResource('staff', StaffController::class);
            Route::post('/tasks', [TaskController::class, 'store']);
            Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
        });

        // Admin and Staff (staff sees and updates only their own tasks)
        Route::get('/tasks', [TaskController::class, 'index']);
        Route::get('/tasks/{task}', [TaskController::class, 'show']);
        Route::match(['put', 'patch'], '/tasks/{task}', [TaskController::class, 'update']);
    });
});