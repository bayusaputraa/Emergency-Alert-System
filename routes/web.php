<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AlertController;

Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/alerts', [DashboardController::class, 'alerts'])->name('dashboard.alerts');

    // Device routes
    Route::resource('devices', DeviceController::class);
    Route::post('/devices/{device}/regenerate-api-key', [DeviceController::class, 'regenerateApiKey'])
        ->name('devices.regenerate-api-key');

    // Location routes
    Route::resource('locations', LocationController::class);

    // Alert routes
    Route::get('/alerts/{alert}', [AlertController::class, 'show'])->name('alerts.show');
    Route::post('/alerts/{alert}/acknowledge', [AlertController::class, 'acknowledge'])->name('alerts.acknowledge');
});

Route::middleware('auth')->group(function () {
    // Tambahkan route profile.edit
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    // Route-route lain yang sudah ada...
});

use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (Laravel Breeze or UI)
require __DIR__.'/auth.php';
