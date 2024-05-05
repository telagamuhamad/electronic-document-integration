<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\DeliveryOrderController;
use App\Http\Controllers\Admin\GoodReturnNoteController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\TravelDocumentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::prefix('edi')->name('edi.')->group(function () {
    Route::prefix('delivery-order')->name('delivery-order.')->group(function () {
        Route::get('/', [DeliveryOrderController::class, 'index'])->name('index'); 
        Route::get('show/{id}', [DeliveryOrderController::class, 'show'])->name('show');
        Route::get('create', [DeliveryOrderController::class, 'create'])->name('create');
        Route::post('store', [DeliveryOrderController::class, 'store'])->name('store');
        Route::get('convert/{id}', [DeliveryOrderController::class, 'convert'])->name('convert');
        Route::get('print/{id}', [DeliveryOrderController::class, 'print'])->name('print');
        Route::post('receive/{id}', [DeliveryOrderController::class, 'receive'])->name('receive');
    });

    Route::prefix('good-return-note')->name('good-return-note.')->group(function () {
        Route::get('/', [GoodReturnNoteController::class, 'index'])->name('index');
        Route::get('show/{id}', [GoodReturnNoteController::class, 'show'])->name('show');
        Route::get('convert/{id}', [GoodReturnNoteController::class, 'convertToInvoice'])->name('convert');
        Route::get('print/{id}', [GoodReturnNoteController::class, 'print'])->name('print');
    });

    Route::prefix('invoice')->name('invoice.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('show/{id}', [InvoiceController::class, 'show'])->name('show');
        Route::put('confirm-payment/{id}', [InvoiceController::class, 'confirmPayment'])->name('confirm-payment');
        Route::get('print/{id}', [InvoiceController::class, 'print'])->name('print');
    });

    Route::prefix('car')->name('car.')->group(function () {
        Route::get('/', [CarController::class, 'index'])->name('index');
        Route::get('create', [CarController::class, 'create'])->name('create');
        Route::post('store', [CarController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CarController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [CarController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [CarController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('travel-document')->name('travel-document.')->group(function () {
        Route::get('/', [TravelDocumentController::class, 'index'])->name('index');
        Route::get('show/{id}', [TravelDocumentController::class, 'show'])->name('show');
        Route::get('show-item/{id}', [TravelDocumentController::class, 'showItem'])->name('show-item');
        Route::get('print/{id}', [TravelDocumentController::class, 'print'])->name('print');
    });

    Route::prefix('user-access-management')->name('user-access-management.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('show/{id}', [UserManagementController::class, 'show'])->name('show');
        Route::get('create', [UserManagementController::class, 'create'])->name('create');
        Route::post('store', [UserManagementController::class, 'store'])->name('store');
        Route::put('update', [UserManagementController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
    });
});