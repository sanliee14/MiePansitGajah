<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OwnerController;

Route::get('/', function () {
    return view('customer.home');
});

Route::get('/kasir/login', function () {
    return view('kasir.login');
})->name('kasir.loginForm');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
});

Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir', function () {
        return view('kasir.dashboard');
    });
});

// Customer
Route::get('/cust/home', [CustomerController::class, 'dashboard'])->name('cust.home');
Route::get('/customer/data', [CustomerController::class, 'data'])->name('customer.data');
Route::get('/customer/order', [CustomerController::class, 'order'])->name('customer.order');
Route::get('/customer/fav', [CustomerController::class, 'fav'])->name('customer.fav');
Route::get('/customer/makanan', [CustomerController::class, 'makanan'])->name('customer.makanan');
Route::get('/customer/minuman', [CustomerController::class, 'minuman'])->name('customer.minuman');
Route::get('/customer/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
Route::get('/customer/qris', [CustomerController::class, 'qris'])->name('customer.qris');
Route::POST('/customer/proses', [CustomerController::class, 'proses'])->name('customer.proses');


// Kasir
Route::post('/kasir/login', [KasirController::class, 'login'])->name('kasir.login');
Route::get('/kasir/menu', [KasirController::class, 'menu'])->name('kasir.menu');
Route::get('/kasir/accpesanan', [KasirController::class, 'accpesanan'])->name('kasir.accpesanan');
Route::get('/kasir/prosespesanan', [KasirController::class, 'prosespesanan'])->name('kasir.prosespesanan');
Route::get('/kasir/history', [KasirController::class, 'history'])->name('kasir.history');

// Owner
Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
Route::get('/owner/laporan', [OwnerController::class, 'laporan'])->name('owner.laporan');