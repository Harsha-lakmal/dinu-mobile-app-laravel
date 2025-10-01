<?php

use App\Http\Controllers\Auth\AnuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AnuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AnuthController::class, 'login']);
Route::get('/register', [AnuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AnuthController::class, 'register']);
Route::post('/logout', [AnuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AnuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AnuthController::class, 'updateProfile']);
    Route::get('/change-password', [AnuthController::class, 'showChangePassword'])->name('change.password');
    Route::post('/change-password', [AnuthController::class, 'changePassword']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashborad', function () {
        return view('dashborad');
    })->name('dashboard');
    
    Route::get('/categories', function () {
        return view('page.categories');
    })->name('categories');
    
    Route::get('/stock', function () {
        return view('page.stock');
    })->name('stock');
    
    Route::get('/users', function () {
        return view('page.user');
    })->name('users');
    
    Route::get('/settings', function () {
        return view('page.settings');
    })->name('settings');
    
    Route::get('/reports', function () {
        return view('page.report'
);
    })->name('reports');
});