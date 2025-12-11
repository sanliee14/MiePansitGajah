<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
   // --- LOGIN OWNER ---
    public function login()
    {
        return view('owner.login');
    }

   public function proseslogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('Username', $request->username)->first();

        
        if (!$user) {
            return back()->with('error', 'Username tidak ditemukan.');
        }
        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->Password)) {
            return back()->with('error', 'Password salah.');
        }

        if (trim(strtolower($user->Role)) !== 'owner') {
            return back()->with('error', 'Akun ini bukan akun Owner.');
        }

        // --- JIKA LOLOS SEMUA PENGECEKAN DI ATAS ---
        
        // Lakukan Login
        \Illuminate\Support\Facades\Auth::login($user);
        $request->session()->regenerate();

        // Redirect ke Dashboard
        return redirect()->route('owner.dashboard')->with('success', 'Selamat datang Owner!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/owner/login');
    }
    public function dashboard(Request $request)
    {
    // Ambil tanggal filter dari query
    $tanggal = $request->input('tanggal', now()->toDateString());

    // TOTAL PENJUALAN (status selesai Saja)
    $total_hari_ini = DB::table('payment')
        ->whereDate('Waktu_Bayar', $tanggal)
        ->where('Status', 'selesai')
        ->sum('Jumlah_Bayar');

    // JUMLAH PESANAN MASUK (yang sudah bayar => bukan menunggu)
    $jumlah_pesanan = DB::table('payment')
        ->whereDate('Waktu_Bayar', $tanggal)
        ->where('Status', '!=', 'menunggu')
        ->count();

    // TOTAL PRODUK (jumlah menu)
    $total_produk = DB::table('product')->count();

    // TRANSAKSI TERBARU sesuai filter tanggal
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
        ->get();

    return view('owner.dashboard', compact(
        'total_hari_ini',
        'jumlah_pesanan',
        'total_produk',
        'transaksi',
        'tanggal'
    ));
}

public function editpesanan($id)
    {
    // Ambil data utama pesanan
    $cart = DB::table('cart')
        ->leftJoin('payment', 'cart.Id_Cart', '=', 'payment.Id_Cart')
        ->select(
            'cart.*',
            'payment.Waktu_Bayar'
        )
        ->where('cart.Id_Cart', $id)
        ->first();

    // Item detail
    $items = DB::table('detail_cart')
        ->join('product', 'detail_cart.Id_Product', '=', 'product.Id_Product')
        ->select(
            'detail_cart.Id_Detail_Cart',
            'product.Nama_Product',
            'product.Harga',
            'detail_cart.Quantity',
            DB::raw('product.Harga * detail_cart.Quantity AS Subtotal')
        )
        ->where('detail_cart.Id_Cart', $id)
        ->get();

    // Total
    $total = $items->sum('Subtotal');

    return view('owner.editpesanan', compact('cart', 'items', 'total'));
    }

    public function updatepesanan(Request $request, $id)
    {
    DB::table('detail_cart')
        ->where('Id_Detail_Cart', $id)
        ->update([
            'Quantity' => $request->quantity
        ]);

    return back()->with('success', 'Jumlah berhasil diperbarui');
    }

    public function hapusitem($id)
    {
    DB::table('detail_cart')->where('Id_Detail_Cart', $id)->delete();

    return back()->with('success', 'Produk berhasil dihapus');
    }

    public function product()
    {
        // ambil semua produk dari tabel product
        $product = DB::table('product')->get();
        return view('owner.product', compact('product'));
    }

    // TAMPIL FORM + SIMPAN PRODUK
    public function tambahproduct(Request $request)
    {
        // Jika GET → tampilkan form
        if ($request->isMethod('get')) {
            return view('owner.tambahproduct');
        }

        // Jika POST → simpan ke database
        $request->validate([
            'Nama_Product'    => 'required',
            'Harga'    => 'required|integer',
            'kategori' => 'required',
            'Deskripsi'    => 'required',
            'Image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imageName = time() . '.' . $request->Image->extension();
        $request->Image->move(public_path('product'), $imageName);

        DB::table('product')->insert([
            'Nama_Product' => $request->Nama_Product,
            'Harga'        => $request->Harga,
            'kategori'     => $request->kategori,
            'Deskripsi'    => $request->Deskripsi,
            'Image'        => $imageName
        ]);

        return redirect()->route('owner.product')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function simpanpesanan($id)
{
    // Hitung ulang total
    $items = DB::table('detail_cart')
        ->join('product', 'detail_cart.Id_Product', '=', 'product.Id_Product')
        ->where('detail_cart.Id_Cart', $id)
        ->select(DB::raw('SUM(product.Harga * detail_cart.Quantity) AS total'))
        ->first();

    // Update cart subtotal
    DB::table('cart')
        ->where('Id_Cart', $id)
        ->update([
            'Subtotal' => $items->total
        ]);

    // Update payment jumlah bayar
    DB::table('payment')
        ->where('Id_Cart', $id)
        ->update([
            'Jumlah_Bayar' => $items->total
        ]);

    return redirect()->route('owner.dashboard')
        ->with('success', 'Pesanan berhasil disimpan!');
}


    // public function editpesanan()
    // {
    //     return view('owner.editpesanan');
    // }

    public function editproduct($id)
    {
    $product = Product::findOrFail($id);
    return view('owner.editproduct', compact('product'));
    }   

    // Update produk
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'Nama_Product' => 'required|string|max:100',
            'Harga' => 'required|numeric',
            'Image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $product->Nama_Product = $request->Nama_Product;
        $product->Harga = $request->Harga;

        // Jika ada gambar baru
        if ($request->hasFile('Image')) {
            // Hapus gambar lama
            if (!empty($product->Image) && file_exists(public_path('product/' . $product->Image))) {
                unlink(public_path('product/' . $product->Image));
            }

            // Simpan gambar baru
            $file = $request->file('Image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('product'), $filename);
            $product->Image = $filename;
        }

        $product->save();

        return redirect()->route('owner.product')->with('success', 'Produk berhasil diperbarui.');
    }

    public function deleteproduct($id)
    {
    $product = Product::find($id);

    if (!$product) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

    // Hapus gambar jika ada
    if (!empty($product->Image) && file_exists(public_path('product/' . $product->Image))) {
        unlink(public_path('product/' . $product->Image));
    }

    // Hapus data dari database
    $product->delete();

    return redirect()->route('owner.product')->with('success', 'Produk berhasil dihapus.');
}

    // Transaksi
    public function transaksi(Request $request)
    {
    $tanggal = $request->tanggal;

    $transaksi = DB::table('cart')
        ->join('payment', 'cart.Id_Cart', '=', 'payment.Id_Cart')
        ->select(
            'cart.Id_Cart',
            'cart.Nama',
            'cart.No_Meja',
            'cart.Status',
            'payment.Waktu_Bayar',
            'payment.Jumlah_Bayar'
        )
        ->when($tanggal, function ($q) use ($tanggal) {
            return $q->whereDate('payment.Waktu_Bayar', $tanggal);
        })
        ->where('cart.Status', 'selesai')
        ->orderBy('payment.Waktu_Bayar', 'desc')
        ->get();

    return view('owner.transaksi', compact('transaksi', 'tanggal'));
    }

    public function detailtransaksi($id)
{
    $cart = DB::table('cart')
        ->join('payment', 'cart.Id_Cart', '=', 'payment.Id_Cart')
        ->select(
            'cart.Id_Cart',
            'cart.Nama',
            'cart.No_Meja',
            'payment.Catatan',
            'cart.Status',
            'payment.Jumlah_Bayar',
            'payment.Metode',
            'payment.Waktu_Bayar'
        )
        ->where('cart.Id_Cart', $id)
        ->first();
        if (!$cart) {
    return view('kasir.detailhistory', compact('cart'));
    }
    }

    public function hapustransaksi($id)
    {
    try {
        // Hapus detail cart terlebih dahulu
        DB::table('detail_cart')->where('Id_Cart', $id)->delete();

        // Hapus payment
        DB::table('payment')->where('Id_Cart', $id)->delete();

        // Hapus cart
        DB::table('cart')->where('Id_Cart', $id)->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
    }
}

    // Laporan (static juga)
    public function laporan()
    {
        $tanggalHariIni = date('Y-m-d');

    // 1. Laporan harian (semua tanggal)
    $laporanHarian = DB::table('payment')
        ->where('Status', 'selesai')
        ->selectRaw('DATE(Waktu_Bayar) as tanggal, COUNT(Id_Payment) as jumlah_transaksi, SUM(Jumlah_Bayar) as total_penjualan')
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'asc')
        ->get();

    // 2. Data chart (7 hari terakhir)
    $laporan7Hari = DB::table('payment')
        ->where('Status', 'selesai')
        ->whereDate('Waktu_Bayar', '>=', date('Y-m-d', strtotime('-6 days')))
        ->selectRaw('DATE(Waktu_Bayar) as tanggal, SUM(Jumlah_Bayar) as total')
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

    $labels = $laporan7Hari->pluck('tanggal');
    $totals = $laporan7Hari->pluck('total');

    // 3. Produk terlaris hari ini (3 produk)
    $produkTerlarisHariIni = DB::table('detail_cart as dc')
        ->join('cart as c', 'dc.Id_Cart', '=', 'c.Id_Cart')
        ->join('payment as p', 'c.Id_Cart', '=', 'p.Id_Cart')
        ->join('product as pr', 'dc.Id_Product', '=', 'pr.Id_Product')
        ->where('p.Status', 'selesai')
        ->whereDate('p.Waktu_Bayar', $tanggalHariIni)
        ->select('pr.Nama_Product', DB::raw('SUM(dc.Quantity) as jumlah_terjual'))
        ->groupBy('pr.Id_Product', 'pr.Nama_Product')
        ->orderByDesc('jumlah_terjual')
        ->limit(3)
        ->get();

    return view('owner.laporan', compact(
        'laporanHarian', 
        'labels', 
        'totals', 
        'produkTerlarisHariIni',
        'tanggalHariIni'
    ));
}

    public function edit($id)
    {
    return view('owner.edit', ['id' => $id]);
    }

    public function addorder($id)
    {
    $product = Product::orderBy('Nama_Product')->get();

    return view('owner.addorder', [
        'product' => $product,
        'IdCart' => $id
    ]);
    }

    public function index($IdCart)
    {
    $product = Product::orderBy('Nama_Product')->get();

    return view('owner.addorder', [
        'product' => $product,
        'IdCart' => $IdCart
    ]);
    }

    // Simpan product ke pesanan
    public function menu(Request $request, $IdCart)
    {
    $data = $request->cartItems;

    // Jika datanya berupa JSON string, decode
    if (is_string($data)) {
        $data = json_decode($data, true);
    }

    // Validasi
    if (!is_array($data)) {
        return back()->with('error', 'Format data cartItems tidak valid!');
    }

    foreach ($data as $item) {
        if (!isset($item['id']) || !isset($item['quantity'])) continue;

    DB::table('detail_cart')->insert([
    'Id_Cart' => $IdCart,
    'Id_Product' => $item['id'],
    'Quantity' => $item['quantity'],
    // 'Harga' => $item['price'] ?? 0,
    // 'Subtotal' => ($item['price'] ?? 0) * $item['quantity'],
    ]);
    }

    return redirect()->route('owner.editpesanan', $IdCart)
        ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function addkasir()
    {
        return view('owner.addkasir');
    }

    // TAMPILKAN FORM EDIT
    public function editkasir($id)
    {
        // Ambil data gabungan user dan kasir berdasarkan Id_User
        $data = DB::table('user')
            ->join('kasir', 'user.Id_User', '=', 'kasir.Id_User')
            ->where('user.Id_User', $id)
            ->select('user.*', 'kasir.Kontak_Kasir')
            ->first();

        if (!$data) {
            return back()->with('error', 'Data kasir tidak ditemukan.');
        }

        return view('owner.editkasir', compact('data'));
    }

    // PROSES UPDATE (RESET PASSWORD)
    public function updatekasir(Request $request, $id)
    {
        $request->validate([
            'Nama'     => 'required|string|max:100',
            'Username' => 'required|string|max:50',
            'Kontak'   => 'required|string|max:20',
            'Password' => 'nullable|min:6', // Password BOLEH KOSONG (nullable)
        ]);

        // Siapkan data yang mau diupdate ke tabel User
        $updateUser = [
            'Nama'     => $request->Nama,
            'Username' => $request->Username,
        ];

        // LOGIKA RESET PASSWORD
        // Jika admin mengisi password baru, maka kita Hash dan masukkan ke update
        if ($request->filled('Password')) {
            $updateUser['Password'] = Hash::make($request->Password);
        }

        // Update Tabel User
        DB::table('user')->where('Id_User', $id)->update($updateUser);

        // Update Tabel Kasir
        DB::table('kasir')->where('Id_User', $id)->update([
            'Nama_Kasir'   => $request->Nama,
            'Kontak_Kasir' => $request->Kontak
        ]);

        return redirect()->route('owner.listkasir')->with('success', 'Data kasir berhasil diperbarui.');
    }

    public function storekasir(Request $request)
    {
    $request->validate([
        'Nama_Kasir' => 'required|string|max:100',
        'Username' => 'required|string|max:50|unique:user,Username',
        'Password' => 'required|string|min:6',
        'Kontak_Kasir' => 'required|string|max:20',
    ]);

    // Simpan ke tabel user dan ambil ID baru
    $User = DB::table('user')->insertGetId([
        'Nama' => $request->Nama_Kasir,
        'Username' => $request->Username,
        'Password' => Hash::make($request->Password),
        'Role' => 'kasir'
    ]);

    // Simpan ke tabel kasir menggunakan ID user
    DB::table('kasir')->insert([
        'Id_User' => $User,
        'Nama_Kasir' => $request->Nama_Kasir,
        'Kontak_Kasir' => $request->Kontak_Kasir
    ]);

    return redirect()->route('owner.dashboard')->with('success', 'Akun kasir berhasil dibuat!');
    }

    public function listkasir()
    {
    $kasir = DB::table('kasir')
        ->join('user', 'kasir.Id_User', '=', 'user.Id_User')
        ->select('kasir.*', 'user.Username', 'user.Password')
        ->get();

    return view('owner.listkasir', compact('kasir'));
    }

    public function deletekasir($id)
    {
    // Hapus USER → otomatis kasir terhapus (FK CASCADE)
    DB::table('user')->where('Id_User', $id)->delete();

    return redirect()->route('owner.listkasir')->with('success', 'Kasir berhasil dihapus!');
    }

}

