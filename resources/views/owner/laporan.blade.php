<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Harian | Mie Pansit Gajah Siantar</title>
  @vite('resources/css/app.css')
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-gradient-to-b from-blue-100 via-blue-200 to-white min-h-screen text-gray-800 flex flex-col">

  <!-- Navbar -->
<header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
        <img src="{{ asset('image/fix.png') }}" 
            alt="Logo" 
            class="w-full h-full object-cover">
    </div>
    <div>
      <h1 class="text-xl font-bold uppercase tracking-wide">Mie Pansit Gajah Siantar</h1>
    </div>
    <a href="{{ url('/owner/dashboard') }}" class="ml-auto bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition">
      Back
    </a>
  </nav>
</header> 

  <div class="flex flex-1">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-400 text-white min-h-screen p-6 shadow-xl">
      <h2 class="text-lg font-bold mb-6 text-white/90 uppercase tracking-wide">Menu Owner</h2>
      <ul class="space-y-4">
        <li><a href="{{ url('/owner/dashboard') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition"> Dashboard</a></li>
        <li><a href="{{ url('/owner/transaksi') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition"> Data Transaksi</a></li>
        <li><a href="{{ url('/owner/product') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition"> Product & Harga</a></li>
        <li><a href="{{ url('/owner/laporan') }}" class="block bg-blue-500 py-2 px-3 rounded-full font-semibold text-center shadow hover:bg-blue-600 transition"> Laporan Harian</a></li>
        <li><a href="{{ url('/owner/tambahproduct') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition"> Tambah Product </a></li>
      </ul>
    </aside>

    <!-- Konten Laporan -->
    <main class="flex-1 p-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    @forelse($produkTerlarisHariIni as $produk)
    <div class="bg-white rounded-3xl shadow-md p-6 text-center hover:shadow-blue-300/40 transition">
        <h3 class="text-lg font-semibold text-gray-600"> {{ $produk->Nama_Product }} </h3>
        <p class="text-3xl font-bold text-blue-600 mt-2">
            {{ $produk->jumlah_terjual }}
        </p>
    </div>
    @empty
    <div class="col-span-1 md:col-span-3 bg-white rounded-3xl shadow-md p-6 text-center text-gray-500">
        Belum ada transaksi hari ini
    </div>
    @endforelse

</div>

      <!-- Grafik -->
      <div class="bg-white p-6 rounded-3xl shadow-lg border border-blue-100 mb-10">
        <h3 class="text-lg font-semibold mb-4 text-blue-700">Grafik Penjualan</h3>
        <canvas id="chartPenjualan" height="120"></canvas>
      </div>

      
      <!-- Tabel Laporan -->
      
      <div class="overflow-x-auto bg-white rounded-3xl shadow-lg border border-blue-100">
        <table class="min-w-full rounded-lg">
          <thead class="bg-blue-500 text-white">
            <tr>
              <th class="py-3 px-4 text-left">Tanggal</th>
              <th class="py-3 px-4 text-left">Jumlah Transaksi</th>
              <th class="py-3 px-4 text-left">Total Penjualan (Rp)</th>
            </tr>
          </thead>
          <tbody>
    @foreach($laporanHarian as $lap)
    <tr class="border-b hover:bg-blue-50">
        <td class="py-3 px-4">{{ $lap->tanggal }}</td>
        <td class="py-3 px-4 text-center">{{ $lap->jumlah_transaksi }}</td>
        <td class="py-3 px-4 text-blue-600 font-bold">Rp {{ number_format($lap->total_penjualan, 0, ',', '.') }}</td>
    </tr>
    @endforeach
</tbody>

        </table>
      </div>
    </main>
  </div>

  <!-- Footer -->
  <footer class="py-4 text-center text-gray-500 text-sm mt-auto">
    © {{ date('Y') }} Mie Pansit Gajah Siantar. Semua hak dilindungi.
  </footer>

  <script>
    const ctx = document.getElementById('chartPenjualan');
    const chartPenjualan = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
          label: 'Total Penjualan (Rp)',
          data: {!! json_encode($totals) !!},
          backgroundColor: 'rgba(59,130,246,0.6)',
          borderColor: 'rgba(59,130,246,1)',
          borderWidth: 1,
          borderRadius: 8,
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>