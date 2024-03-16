<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::controller(ProductController::class)->group(function(){
    Route::get('/','index')->name('products.index');
    Route::get('/products/create','create')->name('products.create');
    Route::post('/products','store')->name('products.store');
    Route::get('/products/{productId}/edit','edit')->name('products.edit');
    Route::put('/products/{productId}','update')->name('products.update');
    Route::delete('/products/{productId}','destroy')->name('products.destroy');
    Route::get('/search','index')->name('products.search');
});