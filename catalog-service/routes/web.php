<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

$serveSwagger = function () {
    $path = storage_path('api-docs/api-docs.json');
    if (!file_exists($path)) {
        abort(404, 'Swagger file not found. Run l5-swagger:generate');
    }
    return response()->file($path, ['Content-Type' => 'application/json']);
};

Route::get('/openapi.json', $serveSwagger);
Route::get('/api-docs.json', $serveSwagger);
