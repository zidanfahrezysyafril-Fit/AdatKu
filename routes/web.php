<?php

use Illuminate\Support\Facades\Route;

Route::view('/dashboard', 'dashboard')->name('dashboard');

Route::view('/users', 'dashboard')->name('users.index');   
Route::view('/settings', 'dashboard')->name('settings');   
