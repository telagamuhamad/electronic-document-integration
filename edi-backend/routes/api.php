<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CarController;
use App\Http\Controllers\API\DeliveryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('car')->name('car.')->group(function () {
    Route::get('get-car', [CarController::class, 'getCar'])->name('get-car');
    Route::post('update-car-status', [CarController::class, 'updateCarStatus'])->name('update-car-status');
});

Route::prefix('edi')->name('edi.')->group(function () {
    Route::get('get-travel-document', [DeliveryController::class, 'getData'])->name('get-travel-document');
    Route::post('update-travel-document', [DeliveryController::class, 'updateStatus'])->name('update-travel-document');
    Route::get('get-item', [DeliveryController::class, 'getItems'])->name('get-item');
    Route::post('update-item-status', [DeliveryController::class, 'updateItemStatus'])->name('update-item-status');
});