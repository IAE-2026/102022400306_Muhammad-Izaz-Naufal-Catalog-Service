<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\AddonController;
use App\Http\Controllers\Api\SsoController;

// ── IAE-T2 Contract Routes (X-IAE-KEY required) ──
Route::prefix('v1')->middleware('api.key')->group(function () {

    // Rooms — Catalog CRUD + full integration (SOAP + RabbitMQ)
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/rooms/{id}', [RoomController::class, 'show']);
    Route::post('/rooms', [RoomController::class, 'store']);

    // Addons
    Route::get('/addons', [AddonController::class, 'index']);

    // ── SSO-protected routes (JWT Bearer token required in ADDITION to X-IAE-KEY) ──
    Route::middleware('sso.auth')->group(function () {
        Route::get('/sso/me', [SsoController::class, 'me']);
        Route::post('/sso/verify', [SsoController::class, 'verify']);
    });
});
