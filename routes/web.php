<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/detail-produk', function () {
    return view('detail-produk');
})->name('detail-produk');

Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran');
