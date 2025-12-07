<?php

namespace App\Http\Controllers;

use App\Models\User;
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


public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Tambahkan withHeaders ini untuk memaksa browser lupa segalanya
    return redirect('/kasir/login')->withHeaders([
        'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT',
        'Clear-Site-Data' => '"cache", "storage", "executionContexts"'
    ]);
}

public function proseslogin(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // 2. [PERBAIKAN UTAMA] Gunakan Model User::where
        // Jangan pakai DB::table, supaya settingan 'Id_User' terbaca otomatis
        $user = User::where('Username', $request->username)->first();

        // 3. Cek apakah user ditemukan
        if (!$user) {
            return back()->with('error', 'Username tidak ditemukan.');
        }

        // 4. Cek Password (menggunakan Hash)
        if (!Hash::check($request->password, $user->Password)) {
            return back()->with('error', 'Password salah.');
        }

        // 5. [PERBAIKAN UTAMA] Login User
        // Auth::login akan menyimpan sesi user dengan benar karena kita pakai Model
        Auth::login($user);
        
        // 6. Regenerasi Session agar tidak mental/logout sendiri
        $request->session()->regenerate();

        // 7. Redirect ke dashboard
        return redirect()->route('kasir.dashboard')->with('success', 'Berhasil login.');
    }

    public function dashboardkasir()
    {
        $product = DB::table('product')->get();
        return view('kasir.dashboard', compact('product'));
    }
    public function searchProduct(Request $request)
{
    $keyword = $request->input('q');

    $product = DB::table('product')
        ->where('Nama_Product', 'LIKE', "%{$keyword}%")
        ->orWhere('Harga', 'LIKE', "%{$keyword}%")
        ->orderBy('Id_Product', 'desc')
        ->get();

    return view('kasir.dashboard', compact('product', 'keyword'));
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
    // 1. Ambil ID User yang sedang login (12348)
    $idUser = auth()->user()->Id_User;

    // 2. Cari ID Kasir aslinya di tabel 'kasir' berdasarkan Id_User tadi
    $dataKasir = DB::table('kasir')->where('Id_User', $idUser)->first();

    // Cek jika akun ini ternyata belum terdaftar sebagai kasir
    if (!$dataKasir) {
        return redirect()->back()->with('error', 'Error: Akun login ini tidak terdaftar di tabel Kasir.');
    }

    $idKasirAsli = $dataKasir->Id_Kasir; // Ini akan mengambil angka 1

    // 3. Update status cart
    DB::table('cart')
        ->where('Id_Cart', $id)
        ->update([
            'Status' => 'selesai',
            'updated_at' => now()
        ]);

    // 4. Update payment dengan Id_Kasir yang BENAR
    DB::table('payment')
        ->where('Id_Cart', $id)
        ->update([
            'Status' => 'selesai',
            'Id_Kasir' => $idKasirAsli, // Masukkan 1, bukan 12348
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
        // Cukup Join ke tabel kasir saja
        ->leftJoin('kasir', 'payment.Id_Kasir', '=', 'kasir.Id_Kasir')
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
            // Ambil Nama_Kasir langsung dari tabel kasir (Sesuai Gambar Database Anda)
            'kasir.Nama_Kasir as NamaKasir' 
        )
        ->where('cart.Id_Cart', $id)
        ->first();

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

