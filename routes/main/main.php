<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\main\MainController;

Route::get('/', [MainController::class, 'dashboard'])->name('dashboard');
Route::get('/stock', [MainController::class, 'stock'])->name('stock');
Route::get('/reports', [MainController::class, 'reports'])->name('reports');
Route::get('/categories', [MainController::class, 'categories'])->name('categories');
Route::get('/users', [MainController::class, 'users'])->name('users');
Route::get('/settings', [MainController::class, 'settings'])->name('settings');
