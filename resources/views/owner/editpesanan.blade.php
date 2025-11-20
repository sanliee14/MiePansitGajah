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
  <nav class="bg-blue-500 text-white flex justify-between items-center px-6 py-3 shadow">
    <div class="flex items-center space-x-3">
      <img src="{{ asset('image/fix.png') }}" class="w-10 h-10 rounded-full ring-2 ring-white">
      <h1 class="text-xl font-bold uppercase">Mie Pansit Gajah Siantar</h1>
    </div>
    <a href="{{ url('/') }}" class="bg-yellow-400 text-blue-900 px-4 py-2 rounded-full font-semibold hover:bg-yellow-500">
      Logout
    </a>
  </nav>

  <div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-blue-400 text-white p-6 min-h-screen shadow-lg">
      <h2 class="text-lg font-bold mb-6 uppercase">Menu Owner</h2>
      <ul class="space-y-4">
        <li><a href="{{ url('/owner/dashboard') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300">Dashboard</a></li>
        <li><a href="{{ url('/owner/transaksi') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300">Transaksi</a></li>
        <li><a href="{{ url('/owner/produk') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300">Produk</a></li>
        <li><a href="{{ url('/owner/laporan') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300">Laporan</a></li>
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
            <input type="text" class="w-full p-2 rounded border" value="TRX001">
          </div>

          <div>
            <label class="font-medium">Nama Customer</label>
            <input type="text" class="w-full p-2 rounded border" value="Qiara">
          </div>

          <div>
            <label class="font-medium">Tanggal Pesan</label>
            <input type="date" class="w-full p-2 rounded border" value="2025-11-15">
          </div>

          <div>
            <label class="font-medium">Waktu Update Terakhir</label>
            <input type="text" class="w-full p-2 rounded border" value="15 Nov 2025 • 14:32" disabled>
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
            <tr class="border-t">
              <td class="p-3">Mie Pansit Ayam</td>
              <td class="p-3 text-center">
                <input type="number" min="1" value="2" class="w-16 p-1 border rounded text-center">
              </td>
              <td class="p-3 text-right">Rp20.000</td>
              <td class="p-3 text-right">Rp40.000</td>
              <td class="p-3 text-center">
                <button class="bg-red-500 px-3 py-1 text-white rounded hover:bg-red-600">Hapus</button>
              </td>
            </tr>

            <tr class="border-t">
              <td class="p-3">Es Teh Manis</td>
              <td class="p-3 text-center">
                <input type="number" min="1" value="1" class="w-16 p-1 border rounded text-center">
              </td>
              <td class="p-3 text-right">Rp8.000</td>
              <td class="p-3 text-right">Rp8.000</td>
              <td class="p-3 text-center">
                <button class="bg-red-500 px-3 py-1 text-white rounded hover:bg-red-600">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Tombol Tambah -->
        <div class="mt-4 pt-4 border-t">
          <a href="{{ url('/customer/order') }}"
             class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">
            + Tambah Pesanan
          </a>
        </div>
      </div>

      <!-- TOTAL + BUTTON -->
<div class="bg-white p-6 rounded-xl shadow mb-8">
  <div class="flex justify-between text-xl font-bold mb-4">
    <span>Total Pembayaran</span>
    <span class="text-blue-600">Rp48.000</span>
  </div>

  <div class="flex justify-center gap-4"> 
    <!-- GAP antar tombol otomatis -->

    <a href="{{ url('/owner/transaksi') }}"
       class="bg-red-500 text-white px-5 py-2 rounded-full hover:bg-blue-500">
      Kembali
    </a>

    <a href="{{ url('/owner/transaksi') }}"
       class="bg-blue-500 text-white px-5 py-2 rounded-full hover:bg-yellow-500">
      Simpan
    </a>

  </div>
</div>


      <footer class="py-4 text-center text-gray-600 text-sm">
        © {{ date('Y') }} Mie Pansit Gajah Siantar
      </footer>

    </main>
  </div>

</body>
</html>
