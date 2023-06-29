<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Location\LocationController;
use App\Http\Controllers\Api\Locations\AllController;
use App\Http\Controllers\Api\PingController;
use App\Http\Controllers\Api\Trips\DeleteController;
use App\Http\Controllers\Api\Trips\IndexController;
use App\Http\Controllers\Api\Trips\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/ping', PingController::class)->name('api.ping');

Route::prefix('auth')->name('api.auth.')->group(function (): void {
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', LoginController::class)->name('login');
});

Route::middleware('auth:sanctum')
    ->prefix('locations')
    ->name('api.locations.')->group(function (): void {
        Route::get('/', AllController::class)->name('list-all');
        Route::get('/{location}', LocationController::class)->name('single-location');
    });

Route::middleware('auth:sanctum')
    ->prefix('trips')
    ->name('api.trips.')->group(function (): void {
        Route::post('/', StoreController::class)->name('store');
        Route::get('/', IndexController::class)->name('index');
        Route::delete('/{trip}', DeleteController::class)->name('delete');
    });
