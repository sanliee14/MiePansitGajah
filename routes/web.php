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

Route::post('/customer/order', [CustomerController::class, 'order'])->name('customer.order');
Route::get('/customer/menu', [CustomerController::class, 'menu'])->name('customer.menu');

Route::post('/customer/cart', [CustomerController::class, 'cart'])->name('customer.cart'); // FIX
Route::post('/customer/cartupdate', [CustomerController::class, 'cartupdate'])->name('customer.cartupdate'); // FIX

Route::get('/customer/fav', [CustomerController::class, 'fav'])->name('customer.fav');
Route::get('/customer/makanan', [CustomerController::class, 'makanan'])->name('customer.makanan');
Route::get('/customer/minuman', [CustomerController::class, 'minuman'])->name('customer.minuman');

Route::get('/customer/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
Route::post('/customer/datacheckout', [CustomerController::class, 'datacheckout'])->name('customer.datacheckout');
Route::post('/customer/bayar', [CustomerController::class, 'bayar'])->name('customer.bayar');

Route::get('/customer/qris', [CustomerController::class, 'qris'])->name('customer.qris');
Route::post('/customer/bukti', [CustomerController::class, 'bukti'])->name('customer.bukti');
Route::get('/customer/proses', [CustomerController::class, 'proses'])->name('customer.proses');


// Kasir
Route::get('/kasir/login', [KasirController::class, 'login'])->name('kasir.login');
Route::post('/kasir/proseslogin', [KasirController::class, 'proseslogin'])->name('kasir.proseslogin');
Route::get('/kasir/dashboard', [KasirController::class, 'dashboardkasir'])->name('kasir.dashboard');
Route::get('/kasir/menu', [KasirController::class, 'menu'])->name('kasir.menu');
Route::post('/kasir/tambahproduct', [KasirController::class, 'tambahproduct'])->name('kasir.tambahproduct');
Route::get('/kasir/tambahproduct', [KasirController::class, 'showtambahproduct'])->name('kasir.showtambahproduct');
Route::get('/kasir/accpesanan', [KasirController::class, 'accpesanan'])->name('kasir.accpesanan');
Route::get('/kasir/payment', [KasirController::class, 'payment'])->name('kasir.payment');

Route::get('/kasir/detailpesanan/{id}', [KasirController::class, 'detailpesanan'])->name('kasir.detailpesanan');
Route::post('/kasir/terimapesanan/{id}', [KasirController::class, 'terimapesanan'])->name('kasir.terimapesanan');
Route::get('/kasir/prosespesanan', [KasirController::class, 'prosespesanan'])->name('kasir.prosespesanan');
Route::get('/kasir/detailproses/{id}', [KasirController::class, 'detailproses'])->name('kasir.detailproses');
Route::post('/kasir/selesai/{id}', [KasirController::class, 'selesai'])->name('kasir.selesai');

Route::get('/kasir/history', [KasirController::class, 'history'])->name('kasir.history');
Route::get('/kasir/detailhistory/{id}', [KasirController::class, 'detailhistory'])->name('kasir.detailhistory');

// Owner
Route::get('/owner/login', [OwnerController::class, 'login'])->name('owner.login');
Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
Route::get('/owner/product', [OwnerController::class, 'product'])->name('owner.product');
Route::match(['get', 'post'], '/owner/tambahproduct', [OwnerController::class, 'tambahproduct'])->name('owner.tambahproduct');


Route::get('/owner/editpesanan/{id}', [OwnerController::class, 'editpesanan'])->name('owner.editpesanan');
Route::post('/owner/updatepesanan/{id}', [OwnerController::class, 'updatepesanan'])->name('owner.updatepesanan');
Route::post('/owner/hapusitem/{id}', [OwnerController::class, 'hapusitem'])->name('owner.hapusitem');
Route::post('/owner/simpanpesanan/{id}', [OwnerController::class, 'simpanpesanan'])->name('owner.simpanpesanan');
Route::delete('/owner/transaksi/hapus/{id}', [OwnerController::class, 'hapustransaksi'])->name('owner.transaksi.hapus');


Route::get('/owner/edit', [OwnerController::class, 'editpesanan'])->name('owner.editpesanan');
Route::get('/owner/editproduct/{id}', [OwnerController::class, 'editproduct'])->name('owner.editproduct');
Route::post('/owner/updateproduct/{id}', [OwnerController::class, 'updateproduct'])->name('owner.updateproduct');
Route::delete('/owner/deleteproduct/{id}', [OwnerController::class, 'deleteproduct'])->name('owner.deleteproduct');

Route::get('/owner/transaksi', [OwnerController::class, 'transaksi'])->name('owner.transaksi');
Route::get('/owner/detailtransaksi/{id}', [OwnerController::class, 'detailtransaksi'])
    ->name('owner.detailtransaksi');


Route::get('/owner/laporan', [OwnerController::class, 'laporan'])->name('owner.laporan');
Route::get('/owner/addkasir', [OwnerController::class, 'addkasir'])->name('owner.addkasir');
Route::post('/owner/storekasir', [OwnerController::class, 'storekasir'])->name('owner.storekasir');

Route::get('/owner/listkasir', [OwnerController::class, 'listkasir'])->name('owner.listkasir');
Route::delete('/owner/deletekasir/{id}', [OwnerController::class, 'deletekasir'])->name('owner.deletekasir');

Route::post('/owner/{id}/addproduct', [OwnerController::class, 'menu'])
    ->name('owner.addproduct.menu');
Route::get('/owner/addorder/{id}', [OwnerController::class, 'addorder'])->name('owner.addorder');
Route::get('/owner/{id}/addproduct', [OwnerController::class, 'index'])
    ->name('owner.addproduct');

// Tambahkan product ke pesanan (proses submit)


