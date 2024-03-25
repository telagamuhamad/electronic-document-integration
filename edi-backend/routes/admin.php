<?php

use App\Http\Controllers\Admin\DeliveryOrderController;
use App\Http\Controllers\Admin\GoodReturnNoteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('edi')->name('edi.')->group(function () {
    Route::prefix('delivery-order')->name('delivery-order.')->group(function () {
        Route::get('/', [DeliveryOrderController::class, 'index'])->name('index'); 
    });

    Route::prefix('good-return-note')->name('good-return-note.')->group(function () {
        Route::get('/', [GoodReturnNoteController::class, 'index'])->name('index');
    });
});