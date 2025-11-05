<?php

use App\Http\Controllers\report\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
   
    Route::get('/get/all/data',[ReportController::class,'getAll'])->name('get.all');

});