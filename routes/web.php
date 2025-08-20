<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ThemeController;
 Route::get('/', function () {
    return view('auth.register');
 })->name('register.form');

Route::get('/login', function () {
    return view('auth.login');
})->name('login.form'); 
Route::get('/dashboard',function () {
return view('auth.dashboard');
})->name('dashboard');
Route::get('/store', [StoreController::class, 'create'])->name('store.view');
Route::post('/store', [StoreController::class, 'store'])->name('store.insert');
Route::get('/theme', function () {
    return view('theme'); 
})->name('theme.view');

Route::post('/theme', [ThemeController::class, 'store'])->name('theme.store');


Route::get('/products', [ProductController::class, 'create'])->name('products.view');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

