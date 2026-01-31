<?php

use App\Http\Controllers\HomepageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

Route::get('/product/{id}', [HomepageController::class, 'show'])->name('product.detail');

Route::get('/detail-produk', function () {
    return view('detail-produk');
})->name('detail-produk');

Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran');
