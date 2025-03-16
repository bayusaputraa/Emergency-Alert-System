<?php

// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlertApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API routes for ESP32 devices
Route::middleware('verify.api.key')->group(function () {
    Route::post('/alerts', [AlertApiController::class, 'store']);
});
