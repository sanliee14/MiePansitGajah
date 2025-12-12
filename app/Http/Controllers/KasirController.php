<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function login()
    {
        return view('kasir.login');
    }

    public function proseslogin(Request $request)
    {
    // Validasi input
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    // Cek user berdasarkan username (atau email, sesuai database kamu)
    $user = DB::table('user')
        ->where('Username', $request->username)
        ->first();

    if (!$user) {
        return back()->with('error', 'Username tidak ditemukan.');
    }

    // Cek password (pastikan password di DB sudah di-hash!)
    if (!Hash::check($request->password, $user->Password)) {
        return back()->with('error', 'Password salah.');
    }

    // LOGIN MANUAL (karena pakai table kasir, bukan users)
    auth()->loginUsingId($user->Id_Kasir);

    return redirect()->route('kasir.dashboard')
    ->with('success', 'Berhasil login.');
    }

    public function dashboardkasir()
    {
        $product = DB::table('product')->get();
        return view('kasir.dashboard', compact('product'));
    }

    public function payment()
    {
        return view('kasir.payment');
    }

    public function showtambahproduct()
    {
        return view('kasir.tambahproduct');
    }

    public function dashboard(Request $request)
{
    // FILTER TANGGAL JIKA ADA
    $tanggal = $request->input('tanggal', today()->toDateString());

    // 1. TOTAL PENJUALAN (status selesai)
    $total_hari_ini = DB::table('payment')
        ->whereDate('Waktu_Bayar', $tanggal)
        ->where('Status', 'selesai')
        ->sum('Jumlah_Bayar');

    // 2. JUMLAH PESANAN (yang sudah bayar = tidak menunggu)
    $jumlah_pesanan = DB::table('payment')
        ->whereDate('Waktu_Bayar', $tanggal)
        ->where('Status', '!=', 'menunggu')
        ->count();

    // 3. TOTAL PRODUK (jumlah menu)
    $total_produk = DB::table('product')->count();

    // 4. TRANSAKSI TERBARU
    $transaksi = DB::table('payment')
        ->join('cart', 'payment.Id_Cart', '=', 'cart.Id_Cart')
        ->select(
            'payment.Id_Payment',
            'payment.Id_Cart',
            'payment.Waktu_Bayar',
            'payment.Jumlah_Bayar',
            'payment.Status',
            'cart.Nama'
        )
        ->whereDate('payment.Waktu_Bayar', $tanggal)
        ->orderBy('payment.Id_Payment', 'desc')
        ->take(5)
        ->get();

    return view('owner.dashboard', compact(
        'total_hari_ini',
        'jumlah_pesanan',
        'total_produk',
        'transaksi',
        'tanggal'
    ));
    }

    public function accpesanan()
    {
    $order = DB::table('cart')
            ->join('payment', 'cart.Id_Cart', '=', 'payment.Id_Cart')
            ->select(
                'cart.Id_Cart',
                'cart.Nama',
                'cart.No_Meja',
                'payment.Jumlah_Bayar',
                'payment.Status'
            )
            ->where('payment.Status', 'Menunggu')
            ->orderBy('cart.Id_Cart', 'desc')
            ->get();

        return view('kasir.accpesanan', compact('order'));
    }

    public function detailpesanan($id)
    {
        $cart = DB::table('cart')
        ->join('payment', 'cart.Id_Cart', '=', 'payment.Id_Cart')
        ->select(
            'cart.Id_Cart',
            'cart.Nama',
            'cart.No_Meja',
            'payment.Catatan',
            'payment.Jumlah_Bayar as Total_Harga',
            'payment.Metode',
            'payment.Waktu_Bayar as Waktu_Cart'
        )
        ->where('cart.Id_Cart', $id)
        ->first();

    if (!$cart) {
        return redirect()->route('kasir.prosespesanan')->with('error', 'Pesanan tidak ditemukan.');
    }

    // Ambil detail menu dari detail_cart
    $detail = DB::table('detail_cart')
        ->join('product', 'detail_cart.Id_Product', '=', 'product.Id_Product')
        ->select(
            'product.Nama_Product',
            'product.Harga',
            'product.Image',
            'detail_cart.Quantity as Qty'
        )
        ->where('detail_cart.Id_Cart', $id)
        ->get();

    return view('kasir.detailpesanan', compact('cart', 'detail'));
    }

    public function prosespesanan()
    {
    // Ambil semua pesanan yang sedang diproses
    $order = DB::table('cart')
        ->join('payment', 'cart.Id_Cart', '=', 'payment.Id_Cart')
        ->select(
            'cart.Id_Cart',
            'cart.Nama',
            'cart.No_Meja',
            'payment.Jumlah_Bayar',
            'payment.Status'
        )
        ->where('payment.Status', 'diproses') 
        ->orderBy('cart.Id_Cart', 'desc')
        ->get();

    return view('kasir.prosespesanan', compact('order'));
    }

    public function terimapesanan($id)
    {
    DB::table('payment')
        ->where('Id_Cart', $id)
        ->update([
            'Status' => 'diproses'
        ]);

    return redirect()->route('kasir.prosespesanan');
    }

    public function detailproses($id)
    {
    // Ambil data cart + payment
    $cart = DB::table('cart')
        ->join('payment', 'cart.Id_Cart', '=', 'payment.Id_Cart')
        ->select(
            'cart.Id_Cart',
            'cart.Id_User',
            'cart.Nama',
            'cart.No_Meja',
            'payment.Catatan',
            'payment.Jumlah_Bayar as Total_Harga',
            'payment.Metode',
            'payment.Waktu_Bayar',
            'payment.Status'
        )
        ->where('cart.Id_Cart', $id)
        ->first();

    if (!$cart) {
        return redirect()->route('kasir.prosespesanan')
        ->with('error', 'Pesanan tidak ditemukan.');
    }

    // Ambil detail menu
    $detail = DB::table('detail_cart')
        ->join('product', 'detail_cart.Id_Product', '=', 'product.Id_Product')
        ->select(
            'product.Nama_Product',
            'product.Harga',
            'product.Image',
            'detail_cart.Quantity as Qty'
        )
        ->where('detail_cart.Id_Cart', $id)
        ->get();

    return view('kasir.detailproses', compact('cart', 'detail'));
    }

 public function selesai($id)
{
    // Ambil ID user kasir yang sedang login
    $idkasir = auth()->user()->Id_User;

    // Update status cart
    DB::table('cart')
        ->where('Id_Cart', $id)
        ->update([
            'Status' => 'selesai',
            'updated_at' => now()
        ]);

    // Update payment
    DB::table('payment')
        ->where('Id_Cart', $id)
        ->update([
            'Status' => 'selesai',
            'Id_Kasir' => $idkasir, // simpan kasir yang ACC
            'updated_at' => now()
        ]);

    return redirect()->route('kasir.prosespesanan')
        ->with('success', 'Pesanan telah selesai.');
}

    public function history(Request $request)
    {
    $tanggal = $request->tanggal;

    $order = DB::table('cart')
        ->join('payment', 'cart.Id_Cart', '=', 'payment.Id_Cart')
        ->select(
            'cart.Id_Cart',
            'cart.Nama',
            'cart.No_Meja',
            'cart.Status',
            'payment.Jumlah_Bayar',
            'payment.Waktu_Bayar'
        )
        ->where('cart.Status', 'selesai')
        ->when($tanggal, function ($q) use ($tanggal) {
            return $q->whereDate('payment.Waktu_Bayar', $tanggal);
        })
        ->orderBy('payment.Waktu_Bayar', 'desc')
        ->get();

    return view('kasir.history', compact('order'));
}


    public function detailhistory($id)
    {
    $cart = DB::table('cart')
        ->join('payment', 'cart.Id_Cart', '=', 'payment.Id_Cart')
        ->leftJoin('user', 'payment.Id_Kasir', '=', 'user.Id_User')
        ->select(
            'cart.Id_Cart',
            'cart.Nama',
            'cart.No_Meja',
            'payment.Catatan',
            'cart.Status',
            'payment.Jumlah_Bayar',
            'payment.Metode',
            'payment.Waktu_Bayar',
            'payment.Id_Kasir',
            'users.Name as NamaKasir'
        )
        ->where('cart.Id_Cart', $id)
        ->first();

    if (!$cart) {
        return redirect()->route('kasir.history')
            ->with('error', 'Data tidak ditemukan.');
    }

    if (!$cart) {
        return redirect()->route('kasir.history')->with('error', 'Data tidak ditemukan.');
    }

    // Ambil detail menu yang dipesan
    $detail = DB::table('detail_cart')
        ->join('product', 'detail_cart.Id_Product', '=', 'product.Id_Product')
        ->select(
            'product.Nama_Product',
            'product.Harga',
            'product.Image',
            'detail_cart.Quantity as Qty'
        )
        ->where('detail_cart.Id_Cart', $id)
        ->get();

    return view('kasir.detailhistory', compact('cart', 'detail'));
    }

    public function transaksi()
    {
        return view('kasir.transaksi');
    }
}
