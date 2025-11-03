<?php

use Illuminate\Support\Facades\Route;

Route::get('home', function () {
    return redirect('/home');
});
Route::get('/home', function () {
    return view('home');
})->name('home');
Route::get('toko', function () {
    return redirect('/toko');
});
Route::get('/toko', function () {
    return view('toko');
})->name('toko');
