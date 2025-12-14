<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pesanan | Mie Pansit Gajah Siantar</title>
  @vite('resources/css/app.css')

  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>

<body class="bg-blue-100 min-h-screen text-gray-800">

  <!-- NAVBAR -->
  <header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
        <img src="{{ asset('image/fix.png') }}" 
            alt="Logo" 
            class="w-full h-full object-cover">
    </div>
    <div>
      <h1 class="text-xl font-bold uppercase">Mie Pansit Gajah Siantar</h1>
    </div>
    <a href="{{ url('/owner/dashboard') }}" class="ml-auto bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition">
      Back
    </a>
  </nav>
</header>

  <div class="flex">

    <!-- SIDEBAR -->
     <aside class="w-64 bg-blue-400 text-white min-h-screen p-6 shadow-xl">
      <h2 class="text-xl font-bold mb-6 text-white/90 uppercase tracking-wide">Menu Owner</h2>
      <ul class="space-y-4">
        <li><a href="{{ route('owner.dashboard') }}" class="block bg-blue-500 py-2 px-3 rounded-full text-lg font-bold text-center shadow hover:bg-blue-600 transition"> Dashboard</a></li>
        <li><a href="{{ route('owner.transaksi') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> Data Transaksi</a></li>
        <li><a href="{{ route('owner.product') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> Product & Harga</a></li>
        <li><a href="{{ route('owner.laporan') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> Laporan Harian</a></li>
        <li><a href="{{ route('owner.tambahproduct') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> Tambah Produk</a></li>
        <li><a href="{{ route('owner.addkasir') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> Buat Akun Kasir</a></li>
        <li><a href="{{ route('owner.listkasir') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> List Akun Kasir</a></li>
      </ul>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-8">

      <h2 class="text-3xl font-extrabold text-blue-600 mb-6">
        Edit Pesanan Customer
      </h2>

      <!-- INFO PESANAN -->
      <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h3 class="text-xl font-semibold mb-3">Informasi Pesanan</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <div>
            <label class="font-medium">ID Pesanan</label>
            <input type="text" class="w-full p-2 rounded border bg-gray-100"
              value="#{{ $cart->Id_Cart }}" disabled>
          </div>

          <div>
            <label class="font-medium">Nama Customer</label>
            <input type="text" class="w-full p-2 rounded border bg-gray-100"
              value="{{ $cart->Nama }}" disabled>
          </div>

          <div>
  <label class="font-medium">Tanggal Pesan</label>
  <input type="date" class="w-full p-2 rounded border bg-gray-100"
         value="{{ $cart->Waktu_Bayar ? date('Y-m-d', strtotime($cart->Waktu_Bayar)) : '' }}" disabled>
</div>

<div>
  <label class="font-medium">Waktu Update Terakhir</label>
  <input type="text" class="w-full p-2 rounded border bg-gray-100"
         value="{{ $cart->Waktu_Bayar ? date('d M Y • H:i', strtotime($cart->Waktu_Bayar)) : '' }}" disabled>
</div>


        </div>
      </div>

      <!-- DAFTAR PESANAN -->
      <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h3 class="text-xl font-semibold mb-3">Daftar Pesanan</h3>

        <table class="w-full border-collapse">
          <thead>
            <tr class="bg-blue-100 text-left">
              <th class="p-3">Nama Produk</th>
              <th class="p-3 text-center">Jumlah</th>
              <th class="p-3 text-right">Harga</th>
              <th class="p-3 text-right">Subtotal</th>
              <th class="p-3 text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($items as $item)
            <tr class="border-t">

              <td class="p-3">{{ $item->Nama_Product }}</td>

              <td class="p-3 text-center">
                <form action="{{ route('owner.updatepesanan', $item->Id_Detail_Cart) }}" method="POST">
                  @csrf
                  <input type="number" min="1" name="quantity"
                    value="{{ $item->Quantity }}"
                    class="w-16 p-1 border rounded text-center"
                    onchange="this.form.submit()">
                </form>
              </td>

              <td class="p-3 text-right">Rp{{ number_format($item->Harga,0,',','.') }}</td>

              <td class="p-3 text-right">Rp{{ number_format($item->Subtotal,0,',','.') }}</td>

              <td class="p-3 text-center">
  <div class="flex items-center justify-center gap-2">

    <!-- MINUS BUTTON -->
    <form action="{{ route('owner.updatepesanan', $item->Id_Detail_Cart) }}" method="POST">
      @csrf
      <input type="hidden" name="quantity" value="{{ max(1, $item->Quantity - 1) }}">
      <button
        class="w-10 h-10 flex items-center justify-center bg-red-500 text-white font-bold rounded-full hover:bg-red-600 shadow">
        –
      </button>
    </form>

    <!-- CURRENT QUANTITY -->
    <span class="px-4 py-2 bg-gray-100 border rounded-lg text-lg font-semibold">
      {{ $item->Quantity }}
    </span>

    <!-- PLUS BUTTON -->
    <form action="{{ route('owner.updatepesanan', $item->Id_Detail_Cart) }}" method="POST">
      @csrf
      <input type="hidden" name="quantity" value="{{ $item->Quantity + 1 }}">
      <button
        class="w-10 h-10 flex items-center justify-center bg-blue-300 text-white font-bold rounded-full hover:bg-green-600 shadow">
        +
      </button>
    </form>

  </div>
</td>

            </tr>
            @endforeach
          </tbody>
        </table>

        <!-- Tombol Tambah -->
        <div class="mt-4 pt-4 border-t">
          <a href="{{ route('owner.addorder', ['id' => $cart->Id_Cart]) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">
            + Tambah Pesanan
          </a>
        </div>
      </div>

      <!-- TOTAL + BUTTON -->
      <div class="bg-white p-6 rounded-xl shadow mb-8">
        <div class="flex justify-between text-xl font-bold mb-4">
          <span>Total Pembayaran</span>
          <span class="text-blue-600">
            Rp{{ number_format($total,0,',','.') }}
          </span>
        </div>

        <div class="flex justify-center gap-4">

          <a href="{{ route('owner.dashboard') }}"
            class="bg-red-500 text-white px-5 py-2 rounded-full hover:bg-red-600">
            Kembali
          </a>

          <form action="{{ route('owner.simpanpesanan', $cart->Id_Cart) }}" method="POST">
            @csrf
            <button class="bg-blue-500 text-white px-5 py-2 rounded-full hover:bg-blue-600">
              Simpan
            </button>
          </form>

        </div>
      </div>

      <footer class="py-4 text-center text-gray-600 text-sm">
        © {{ date('Y') }} Mie Pansit Gajah Siantar
      </footer>

    </main>
  </div>

</body>
</html>
