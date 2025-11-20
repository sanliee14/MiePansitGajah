<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Owner | Mie Pansit Gajah Siantar</title>
  @vite('resources/css/app.css')
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-gradient-to-b from-blue-100 via-blue-200 to-white min-h-screen flex flex-col text-gray-800">

  <!-- Navbar -->
<nav class="bg-blue-500 text-white flex justify-between items-center px-6 py-3 shadow-lg">
  <div class="flex items-center space-x-3">
    <div class="relative w-10 h-10">
      <div class="absolute inset-0 bg-blue-400 blur-xl opacity-40 rounded-full"></div>
        <img src="{{ asset('image/fix.png') }}" alt="Logo" class="relative w-10 h-10 rounded-full ring-2 ring-white/70">
    </div>
    <h1 class="text-xl font-bold uppercase tracking-wide">Mie Pansit Gajah Siantar</h1>
    </div>
    <button class="bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition-all duration-200">
      Logout
    </button>
  </nav>

  <div class="flex flex-1">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-400 text-white min-h-screen p-6 shadow-xl">
      <h2 class="text-lg font-bold mb-6 text-white/90 uppercase tracking-wide">Menu Owner</h2>
      <ul class="space-y-4">
        <li><a href="{{ route('owner.dashboard') }}" class="block bg-blue-500 py-2 px-3 rounded-full font-semibold text-center shadow hover:bg-blue-600 transition"> Dashboard</a></li>
        <li><a href="{{ route('owner.transaksi') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition"> Data Transaksi</a></li>
        <li><a href="{{ route('owner.product') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition"> Product & Harga</a></li>
        <li><a href="{{ route('owner.laporan') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition"> Laporan Harian</a></li>
        <li><a href="{{ route('owner.tambahproduct') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition"> Tambah Produk</a></li>
      </ul>
    </aside>

    <!-- Dashboard -->
    <main class="flex-1 p-8">

      <h2 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text mb-8">
        Dashboard Owner
      </h2>

      <!-- Statistik -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-3xl shadow-md p-6 text-center hover:shadow-blue-300/40 transition">
          <h3 class="text-lg font-semibold text-gray-600">Total Penjualan Hari Ini</h3>
          <p class="text-3xl font-bold text-blue-600 mt-2">Rp 1.530.000</p>
        </div>
        <div class="bg-white rounded-3xl shadow-md p-6 text-center hover:shadow-blue-300/40 transition">
          <h3 class="text-lg font-semibold text-gray-600">Jumlah Pesanan</h3>
          <p class="text-3xl font-bold text-green-600 mt-2">48</p>
        </div>
        <div class="bg-white rounded-3xl shadow-md p-6 text-center hover:shadow-blue-300/40 transition">
          <h3 class="text-lg font-semibold text-gray-600">Total Produk</h3>
          <p class="text-3xl font-bold text-yellow-500 mt-2">15</p>
        </div>
      </div>

      <!-- Tabel Transaksi -->
      <section>
        <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text mb-4">
          Transaksi Terbaru
        </h3>

        <div class="overflow-x-auto rounded-2xl shadow-lg border border-blue-100">
          <table class="min-w-full bg-white rounded-lg">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th class="py-3 px-4 text-left">ID Transaksi</th>
                <th class="py-3 px-4 text-left">Tanggal</th>
                <th class="py-3 px-4 text-left">Pelanggan</th>
                <th class="py-3 px-4 text-left">Total</th>
                <th class="py-3 px-4 text-left">Status</th>
                <th class="py-3 px-4 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b hover:bg-blue-50">
                <td class="py-3 px-4">TRX001</td>
                <td class="py-3 px-4">15 Nov 2025</td>
                <td class="py-3 px-4">Qiara</td>
                <td class="py-3 px-4">Rp 104.000</td>
                <td class="py-3 px-4 text-green-600 font-semibold">Lunas</td>
                <td class="py-3 px-4">
                  <a href="{{ route('owner.editpesanan') }}" 
                    class="bg-yellow-400 text-white px-3 py-1 rounded-full hover:bg-yellow-500 transition">Edit</a>
                </td>
              </tr>
              <tr class="border-b hover:bg-blue-50">
                <td class="py-3 px-4">TRX002</td>
                <td class="py-3 px-4">15 Nov 2025</td>
                <td class="py-3 px-4">Sanny</td>
                <td class="py-3 px-4">Rp 54.000</td>
                <td class="py-3 px-4 text-yellow-500 font-semibold">Pending</td>
                <td class="py-3 px-4">
                  <a href="{{ route('owner.editpesanan') }}" 
                    class="bg-yellow-400 text-white px-3 py-1 rounded-full hover:bg-yellow-500 transition">Edit</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

    </main>
  </div>

  <footer class="py-4 text-center text-gray-500 text-sm mt-auto">
    © {{ date('Y') }} Mie Pansit Gajah Siantar. Semua hak dilindungi.
  </footer>

</body>
</html>
