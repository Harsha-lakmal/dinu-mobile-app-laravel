<?php

use App\Http\Controllers\Auth\AnuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AnuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AnuthController::class, 'login']);
Route::get('/register', [AnuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AnuthController::class, 'register']);
Route::post('/logout', [AnuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
   
    Route::post('/profile', [AnuthController::class, 'updateProfile']);
    Route::post('/change-password', [AnuthController::class, 'changePassword'])->name('change.password');
    Route::get('/user-data', [AnuthController::class, 'getUserData'])->name('user.data');
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
    
    Route::get('/profile', function () {
        return view('page.user');
    })->name('users');
    

    
    Route::get('/reports', function () {
        return view('page.report'
);
    })->name('reports');
});