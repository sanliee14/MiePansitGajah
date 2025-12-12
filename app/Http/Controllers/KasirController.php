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

        return redirect('/kasir/login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT',
            'Clear-Site-Data' => '"cache", "storage", "executionContexts"'
        ]);
    }

    public function proseslogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('Username', $request->username)->first();

        if (!$user) {
            return back()->with('error', 'Username tidak ditemukan.');
        }

        if (!Hash::check($request->password, $user->Password)) {
            return back()->with('error', 'Password salah.');
        }

        Auth::login($user);
        $request->session()->regenerate();

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
        $tanggal = $request->input('tanggal', today()->toDateString());

        $total_hari_ini = DB::table('payment')
            ->whereDate('Waktu_Bayar', $tanggal)
            ->where('Status', 'selesai')
            ->sum('Jumlah_Bayar');

        $jumlah_pesanan = DB::table('payment')
            ->whereDate('Waktu_Bayar', $tanggal)
            ->where('Status', '!=', 'menunggu')
            ->count();

        $total_produk = DB::table('product')->count();

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
        $idUser = auth()->user()->Id_User;
        $dataKasir = DB::table('kasir')->where('Id_User', $idUser)->first();

        if (!$dataKasir) {
            return redirect()->back()->with('error', 'Error: Akun login ini tidak terdaftar di tabel Kasir.');
        }

        $idKasirAsli = $dataKasir->Id_Kasir;

        DB::table('cart')
            ->where('Id_Cart', $id)
            ->update([
                'Status' => 'selesai',
                'updated_at' => now()
            ]);

        DB::table('payment')
            ->where('Id_Cart', $id)
            ->update([
                'Status' => 'selesai',
                'Id_Kasir' => $idKasirAsli,
                'updated_at' => now()
            ]);

        return redirect()->route('kasir.prosespesanan')
            ->with('success', 'Pesanan telah selesai.');
    }

    
    public function history(Request $request)
    {
        $tanggal = $request->tanggal;
        $search  = $request->search;

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
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('cart.Nama', 'like', "%{$search}%")
                       ->orWhere('cart.Id_Cart', 'like', "%{$search}%");
                });
            })
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
                'kasir.Nama_Kasir as NamaKasir'
            )
            ->where('cart.Id_Cart', $id)
            ->first();

        if (!$cart) {
            return redirect()->route('kasir.history')->with('error', 'Data tidak ditemukan.');
        }

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

    public function tambahproduct(Request $request)
    {
        $request->validate([
            'Nama_Product' => 'required',
            'Harga'        => 'required|numeric',
            'kategori'     => 'required',
            'Deskripsi'    => 'required',
            'Image'        => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = time() . '.' . $request->Image->getClientOriginalExtension();
        $request->Image->move(public_path('product'), $imageName);

        DB::table('product')->insert([
            'Nama_Product' => $request->Nama_Product,
            'Harga'        => $request->Harga,
            'Kategori'     => $request->kategori,
            'Deskripsi'    => $request->Deskripsi,
            'Image'        => $imageName,
        ]);

        return redirect()->route('kasir.showtambahproduct')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
}
