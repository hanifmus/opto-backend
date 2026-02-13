<?php

use App\Http\Controllers\StockSpecController;
use App\Http\Controllers\StockContactController;
use App\Http\Controllers\StockinReportController;
use App\Http\Controllers\SalesRecordController;
use App\Http\Controllers\UserController;

// Stock Spec Routes
Route::get('stock-spec', [StockSpecController::class, 'index']);
Route::post('stock-spec', [StockSpecController::class, 'store']);
Route::get('stock-spec/{sid}', [StockSpecController::class, 'show']);
Route::put('stock-spec/{sid}', [StockSpecController::class, 'update']);
Route::delete('stock-spec/{sid}', [StockSpecController::class, 'destroy']);

// Stock Contact Routes
Route::get('stock-contact', [StockContactController::class, 'index']);
Route::post('stock-contact', [StockContactController::class, 'store']);
Route::get('stock-contact/{cid}', [StockContactController::class, 'show']);
Route::put('stock-contact/{cid}', [StockContactController::class, 'update']);
Route::delete('stock-contact/{cid}', [StockContactController::class, 'destroy']);

// Stock In Report Routes
Route::post('stockin-report-spec', [StockinReportController::class, 'storeSpec']);
Route::post('stockin-report-contact', [StockinReportController::class, 'storeContact']);
Route::get('stockin-report-spec', [StockinReportController::class, 'indexSpec']);
Route::get('stockin-report-contact', [StockinReportController::class, 'indexContact']);
// Sales Record Routes (stock-out reports)
Route::get('sales-record-spec', [SalesRecordController::class, 'indexSpec']);
Route::get('sales-record-contact', [SalesRecordController::class, 'indexContact']);
Route::post('sales-record-spec', [SalesRecordController::class, 'storeSpec']);
Route::post('sales-record-contact', [SalesRecordController::class, 'storeContact']);

// User Routes (Staff Management)
Route::get('user', [UserController::class, 'index']);
Route::post('user', [UserController::class, 'store']);
Route::post('user/{id}', [UserController::class, 'update']); // POST for multipart/form-data
Route::get('user/{id}', [UserController::class, 'show']);
Route::put('user/{id}', [UserController::class, 'update']);
Route::delete('user/{id}', [UserController::class, 'destroy']);

// Login and session routes (add session support without CSRF)
Route::middleware([\Illuminate\Session\Middleware\StartSession::class])->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::get('me', [UserController::class, 'me']);
    Route::post('logout', [UserController::class, 'logout']);
});