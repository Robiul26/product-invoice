<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/product');
});

Route::resource('product', ProductController::class);
Route::get('/get-products', [ProductController::class, 'getProducts']);
Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
