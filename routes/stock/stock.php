<?php

use App\Http\Controllers\Stock\StockController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
  
Route::get('/stock/fetch', [StockController::class, 'fetch'])->name('stock.fetch');
Route::post('/stock/save', [StockController::class, 'store'])->name('stock.save');
Route::put('/stock/update', [StockController::class, 'update'])->name('stock.update');
Route::delete('/stock/delete', [StockController::class, 'destroy'])->name('stock.delete');

});