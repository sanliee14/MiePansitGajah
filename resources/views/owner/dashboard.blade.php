<!DOCTYPE html>
<html lang="id">
<head>
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
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
<header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
        <img src="{{ asset('image/fix.png') }}" 
            alt="Logo" 
            class="w-full h-full object-cover">
    </div>
    <div>
    <h1 class="text-xl font-bold uppercase tracking-wide">Mie Pansit Gajah Siantar</h1>
    </div>
    <button class="ml-auto bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition-all duration-200">
      Logout
      <a href="{{ route('logout') }}" 
   class="ml-auto bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition-all duration-200 text-center">
   Logout
</a>
    </button>
  </nav>
</header>

  <div class="flex flex-1">

    <!-- Sidebar -->
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

    <!-- Dashboard -->
    <main class="flex-1 p-8">

      <h2 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text mb-8">
        Dashboard Owner
      </h2>

      <form method="GET" class="mb-6">
  <div class="bg-white p-4 rounded-2xl shadow-md flex items-center gap-4 w-fit">
    <label for="tanggal" class="font-semibold text-gray-700">Filter Tanggal:</label>
    <input type="date" name="tanggal" id="tanggal"
           value="{{ $tanggal ?? now()->toDateString() }}"
           class="border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-400">

    <button type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 transition">
      Terapkan
    </button>
  </div>
</form>


      <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <!-- Total Penjualan -->
    <div class="bg-white rounded-3xl shadow-md p-6 text-center hover:shadow-blue-300/40 transition">
      <h3 class="text-lg font-semibold text-gray-600">Total Penjualan</h3>
      <p class="text-3xl font-bold text-blue-600 mt-2">
        Rp {{ number_format($total_hari_ini, 0, ',', '.') }}
      </p>
    </div>

    <!-- Jumlah Pesanan Masuk -->
    <div class="bg-white rounded-3xl shadow-md p-6 text-center hover:shadow-blue-300/40 transition">
      <h3 class="text-lg font-semibold text-gray-600">Jumlah Pesanan Masuk</h3>
      <p class="text-3xl font-bold text-green-600 mt-2">
        {{ $jumlah_pesanan }}
      </p>
    </div>

    <!-- Total Produk -->
    <div class="bg-white rounded-3xl shadow-md p-6 text-center hover:shadow-blue-300/40 transition">
      <h3 class="text-lg font-semibold text-gray-600">Total Produk</h3>
      <p class="text-3xl font-bold text-yellow-500 mt-2">
        {{ $total_produk }}
      </p>
    </div>

</div>


      <!-- Tabel Transaksi -->
      <section>
        <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text mb-4">
          Transaksi Terbaru
        </h3>

        <div class="rounded-2xl shadow-lg border border-blue-100 overflow-hidden">

  <table class="min-w-full bg-white">
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
  </table>

  <!-- BODY SCROLLABLE -->
  <div class="max-h-[350px] overflow-y-auto">
    <table class="min-w-full bg-white">
      <tbody>
        @forelse ($transaksi as $row)
        <tr class="border-b hover:bg-blue-50">
            <td class="py-3 px-4">#{{ $row->Id_Cart }}</td>

            <td class="py-3 px-4">
                {{ \Carbon\Carbon::parse($row->Waktu_Bayar)->format('d M Y H:i') }}
            </td>

            <td class="py-3 px-4">{{ $row->Nama }}</td>

            <td class="py-3 px-4">
                Rp {{ number_format($row->Jumlah_Bayar, 0, ',', '.') }}
            </td>

            <td class="py-3 px-4 font-semibold
                @if($row->Status === 'selesai') text-green-600
                @elseif($row->Status === 'diproses') text-yellow-600
                @else text-red-600 @endif">
                {{ ucfirst($row->Status) }}
            </td>

            <td class="py-3 px-4">
    @if($row->Status !== 'selesai')
        <a href="{{ url('/owner/editpesanan', $row->Id_Cart) }}"
            class="bg-yellow-400 text-white px-3 py-1 rounded-full hover:bg-yellow-500 transition">
            Edit
        </a>
    @else
        <span class="text-gray-400 italic">-</span>
    @endif
</td>

        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">Belum ada transaksi.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>


               <script>
    window.addEventListener("pageshow", function(event) {
        var historyTraversal = event.persisted || 
                               (typeof window.performance != "undefined" && 
                                window.performance.navigation.type === 2);
        
        if (historyTraversal) {
            // Sembunyikan konten agar tidak sempat terbaca
            document.body.style.display = 'none';
            // Paksa reload ke server (server akan menendang ke login)
            window.location.reload(); 
        }
    });
</script>

      </section>

    </main>
  </div>

  <footer class="py-4 text-center text-gray-500 text-sm mt-auto">
    © {{ date('Y') }} Mie Pansit Gajah Siantar. Semua hak dilindungi.
  </footer>

</body>
</html>
