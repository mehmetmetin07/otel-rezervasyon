<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CronJobController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Cron Job API routes
Route::prefix('cron')->group(function () {
    // Ana günlük kontrol (hem check-in hem check-out)
    Route::get('/daily-check', [CronJobController::class, 'dailyReservationCheck']);

    // Ayrı ayrı işlemler
    Route::get('/auto-checkin', [CronJobController::class, 'autoCheckin']);
    Route::get('/auto-checkout', [CronJobController::class, 'autoCheckout']);

    // Durum ve test endpoint'leri
    Route::get('/status', [CronJobController::class, 'status']);
    Route::get('/test', [CronJobController::class, 'testReservationCheck']);
});

// Rezervasyon çakışma kontrolü
Route::post('/check-room-conflict', [\App\Http\Controllers\Api\ReservationCheckController::class, 'checkRoomConflict']);
