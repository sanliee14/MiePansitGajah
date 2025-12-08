<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class CustomerController extends Controller
{
    public function dashboard()
    {
        return view('customer.home');
    }

    public function data()
    {
        return view('customer.data');
    }

    public function menu()
    {
        $product = DB::table('product')->get();
        return view('customer.menu', compact('product'));
    }

    public function searchMenu(Request $request)
    {
        $keyword = $request->search;

        $product = DB::table('product')
            ->where('Nama_Product', 'like', "%{$keyword}%")
            ->orWhere('Kategori', 'like', "%{$keyword}%")
            ->get();

        return view('customer.menu', compact('product'));
    }

    public function order(Request $request)
    {
        try {
            session([
                'nama_customer' => $request->nama,
                'no_meja'       => $request->meja,
            ]);

            DB::table('cart')->insert([
                'Nama'     => $request->nama,
                'No_Meja'  => $request->meja,
                'Status'   => 'diproses',
                'Id_Kasir' => '1',
            ]);

            return redirect('/customer/menu');

        } catch (\Exception $e) {
            $error = $e->getMessage();

            if (str_contains($error, ':')) {
                $error = explode(':', $error, 2)[1];
            }

            if (str_contains($error, '(')) {
                $error = explode('(', $error)[0];
            }

            $error = str_replace(['<<Unknown error>>:', '<Unknown error>'], '', $error);
            $error = preg_replace('/\b1644\b/', '', $error);
            $error = trim($error);

            return back()->withErrors(['db' => $error]);
        }
    }

    public function cart(Request $request)
    {
        $cart = session()->get('cart', []);
        $id   = $request->id;

        if (!isset($cart[$id])) {
            $cart[$id] = [
                'product_id' => $id,
                'name'       => $request->name,
                'price'      => $request->price,
                'qty'        => 1,
            ];
        } else {
            $cart[$id]['qty']++;
        }

        session()->put('cart', $cart);

        return response()->json([
            'count' => array_sum(array_column($cart, 'qty')),
            'total' => array_sum(array_map(fn($i) => $i['qty'] * $i['price'], $cart)),
        ]);
    }

    public function cartupdate(Request $request)
    {
        $cart   = session()->get('cart', []);
        $id     = $request->id;
        $action = $request->action; // plus atau minus

        if (!isset($cart[$id])) {
            return response()->json(['error' => 'Item tidak ditemukan'], 400);
        }

        if ($action === 'plus') {
            $cart[$id]['qty']++;
        }

        if ($action === 'minus') {
            $cart[$id]['qty']--;

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);

        $totalQty    = array_sum(array_column($cart, 'qty'));
        $totalPrice  = array_sum(array_map(fn($i) => $i['qty'] * $i['price'], $cart));

        return response()->json([
            'qty'   => $cart[$id]['qty'] ?? 0,
            'count' => $totalQty,
            'total' => $totalPrice,
        ]);
    }


    public function fav()
    {
        $products = DB::table('product')->get();
        return view('customer.fav', ['products' => $products]);
    }

    public function makanan()
    {
        $products = DB::table('product')->where('kategori', 'makanan')->get();
        return view('customer.makanan', ['products' => $products]);
    }

    public function minuman()
    {
        $products = DB::table('product')->where('kategori', 'minuman')->get();
        return view('customer.minuman', ['products' => $products]);
    }


    /**
     * CHECKOUT – dipakai customer & kasir.
     * Kalau dipanggil via route kasir.* -> form action ke kasir.bayar
     * Kalau via route customer.* -> form action ke customer.bayar
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong');
        }

        $nama = session('nama_customer');
        $meja = session('no_meja');

        $total = array_sum(array_map(function ($item) {
            return $item['qty'] * $item['price'];
        }, $cart));

        // bedakan asal route
        $action = $request->routeIs('kasir.*')
            ? route('kasir.bayar')
            : route('customer.bayar');

        return view('customer.checkout', [
            'cart'   => $cart,
            'nama'   => $nama,
            'meja'   => $meja,
            'total'  => $total,
            'action' => $action,
        ]);
    }

    /**
     * Simpan nama & meja ke session.
     * Kalau yang manggil kasir -> redirect ke kasir.checkout
     * Kalau customer biasa -> redirect ke customer.checkout
     */
    public function datacheckout(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'meja' => 'required',
        ]);

        session([
            'nama_customer' => $request->nama,
            'no_meja'       => $request->meja,
        ]);

        if ($request->routeIs('kasir.*')) {
            return redirect()->route('kasir.checkout');
        }

        return redirect()->route('customer.checkout');
    }

    /**
     * BAYAR – dipakai customer & kasir.
     * Kasir (cash) -> langsung ke kasir.accpesanan
     * Customer (cash) -> ke customer.proses
     */
    public function bayar(Request $request)
    {
        $payment = $request->payment_method; // cash, qris, dll
        $cart    = session()->get('cart', []);
        $total   = $request->total;

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $idCart = DB::table('cart')->insertGetId([
            'Nama'     => $request->nama ?? session('nama_customer'),
            'No_Meja'  => $request->meja ?? session('no_meja'),
            'Status'   => 'diproses',
            'Id_Kasir' => 1,
        ]);

        foreach ($cart as $item) {
            DB::table('detail_cart')->insert([
                'Id_Cart'    => $idCart,
                'Id_Product' => $item['product_id'],
                'Quantity'   => $item['qty'],
            ]);
        }

        DB::table('payment')->insert([
            'Id_Cart'          => $idCart,
            'Metode'           => $payment,
            'Waktu_Bayar'      => now(),
            'Jumlah_Bayar'     => $total,
            'Status'           => 'Menunggu',
            'Catatan'          => $request->catatan,
            'Bukti_Pembayaran' => null,
        ]);

        session([
            'last_payment_cart' => $cart,
            'last_payment_id'   => $idCart,
        ]);

        session()->forget('cart');

        // ====== BEDAKAN KASIR vs CUSTOMER ======
        if ($payment === 'cash') {

            // Pesanan dibuat lewat kasir (route kasir.bayar)
            if ($request->routeIs('kasir.*')) {
                return redirect()->route('kasir.accpesanan')
                    ->with('success', 'Pesanan berhasil dicatat.');
            }

            // Pesanan langsung dari customer
            return redirect()->route('customer.proses')
                ->with('success', 'Pembayaran berhasil dicatat.');
        }

        // QRIS / metode lain tetap ke halaman QRIS
        return redirect()->route('customer.qris')
            ->with('success', 'Silahkan lanjutkan pembayaran QRIS.');
    }

    public function proses()
    {
        $cart = session('last_payment_cart', []);

        $payment = DB::table('payment')
            ->leftJoin('kasir', 'payment.Id_Kasir', '=', 'kasir.Id_Kasir')
            ->select(
                'payment.Catatan',
                'payment.Metode',
                'payment.Jumlah_Bayar',
                'payment.Waktu_Bayar',
                'payment.Id_Kasir',
                'payment.Id_Cart',
                'payment.Status',
                'kasir.Nama_Kasir as NamaKasir'
            )
            ->where('payment.Id_Cart', session('last_payment_id'))
            ->first();

        $nama = session('nama_customer', 'Customer');
        $meja = session('no_meja', '-');

        if (empty($cart) || !$payment) {
            return redirect()->route('customer.checkout')
                ->with('error', 'Tidak ada pesanan terbaru.');
        }

        return view('customer.proses', [
            'cart'    => $cart,
            'payment' => $payment,
            'nama'    => $nama,
            'meja'    => $meja,
        ]);
    }

    public function bukti(Request $request)
    {
        $request->validate([
            'bukti' => 'required|image|max:2048',
        ]);

        $file     = $request->file('bukti');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('bukti'), $filename);

        DB::table('payment')->where('Id_Cart', session('last_payment_id'))->update([
            'Bukti_Pembayaran' => $filename,
            'Status'           => 'menunggu',
        ]);

        return redirect()->route('customer.proses')->with('success', 'Bukti pembayaran berhasil dikirim.');
    }

    public function qris()
    {
        return view('customer.qris');
    }
}
