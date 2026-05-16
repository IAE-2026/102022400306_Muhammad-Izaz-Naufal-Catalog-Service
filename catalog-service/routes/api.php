<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;

use App\Http\Controllers\Api\AddonController;

Route::prefix('v1')->middleware('api.key')->group(function () {
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/rooms/{id}', [RoomController::class, 'show']);
    Route::post('/rooms', [RoomController::class, 'store']);
    
    Route::get('/addons', [AddonController::class, 'index']);
});
