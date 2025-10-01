<?php

use App\Http\Controllers\Categories\CategoryController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
   Route::post('/subcategories/save',[CategoryController::class,'store'])->name('subcategories.store');
   Route::get('/subcategories/fetch',[CategoryController::class,'fetch'])->name('subcategories.fetch');
   Route::delete('/subcategories/delete',[CategoryController::class,'destroy'])->name('subcategories.destroy');
   Route::post('/categories/save',[CategoryController::class,'save'])->name('categories.store');
   Route::get('categories/getAll',[CategoryController::class,'getAll'])->name('categories.fetch');
   Route::delete('/categories/delete',[CategoryController::class,'deleteCategory'])->name('categories.destroy');
   Route::put('/categories/update', [CategoryController::class, 'updateCategory'])->name('categories.update');
   Route::put('/subcategories/update', [CategoryController::class, 'updatSsubcategories'])->name('subCategories.update');


});