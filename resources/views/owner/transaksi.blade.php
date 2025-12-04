<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Transaksi | Mie Pansit Gajah Siantar</title>
  @vite('resources/css/app.css')
  <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>

<body class="bg-gradient-to-b from-blue-100 via-blue-200 to-white min-h-screen text-gray-800 flex flex-col">

  <!-- Navbar -->
<header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
        <img src="{{ asset('image/fix.png') }}" 
            alt="Logo" 
            class="w-full h-full object-cover">
    </div>
    </div>
    <a href="{{ url('/owner/dashboard') }}" class="ml-auto bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition">
      Back
    </a>
  </nav>
</header>

  <!-- Layout -->
  <div class="flex flex-1">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-400 text-white min-h-screen p-6 shadow-xl">
      <h2 class="text-lg font-bold mb-6 text-white/90 uppercase tracking-wide">Menu Owner</h2>
      <ul class="space-y-4">
        <li><a href="{{ url('/owner/dashboard') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300">Dashboard</a></li>
        <li><a href="{{ url('/owner/transaksi') }}" class="block bg-blue-500 py-2 px-3 text-center rounded-full font-semibold shadow">Data Transaksi</a></li>
        <li><a href="{{ url('/owner/product') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300">Product & Harga</a></li>
        <li><a href="{{ url('/owner/laporan') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300">Laporan Harian</a></li>
        <li><a href="{{ url('/owner/tambahproduct') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300">Tambah Produk</a></li>
      </ul>
    </aside>

    <!-- Konten -->
    <main class="flex-1 p-8">

      <h2 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text mb-8">
        Data Transaksi
      </h2>

      <!-- Filter Tanggal -->
      <form method="GET" class="mb-6">
        <div class="bg-white p-4 rounded-2xl shadow-md flex items-center gap-4 w-fit">
          <label class="font-semibold">Filter Tanggal:</label>
          <input type="date" name="tanggal" value="{{ $tanggal }}"
            class="border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-400" onchange="this.form.submit()">
        </div>
      </form>

      <!-- TABLE -->
      <div class="overflow-x-auto bg-white rounded-3xl shadow-lg border border-blue-100">
        <table class="min-w-full rounded-lg">
          <thead class="bg-blue-500 text-white">
            <tr>
              <th class="py-3 px-4 text-left">ID Transaksi</th>
              <th class="py-3 px-4 text-left">Pelanggan</th>
              <th class="py-3 px-4 text-left">Nomor Meja</th>
              <th class="py-3 px-4 text-left">Tanggal Transaksi</th>
              <th class="py-3 px-4 text-left">Total</th>
              <th class="py-3 px-4 text-left">Status</th>
              <th class="py-3 px-4 text-left">Aksi</th>
            </tr>
          </thead>

          <tbody>
@forelse ($transaksi as $row)
<tr class="border-b hover:bg-blue-50">

    <td class="py-3 px-4">#{{ $row->Id_Cart }}</td>

    <td class="py-3 px-4">{{ $row->Nama }}</td>

    <td class="py-3 px-4">{{ $row->No_Meja }}</td>

    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($row->Waktu_Bayar)->format('d M Y H:i') }}</td>

    <td class="py-3 px-4">Rp {{ number_format($row->Jumlah_Bayar, 0, ',', '.') }}</td>

    <td class="py-3 px-4 font-semibold text-green-600">{{ ucfirst($row->Status) }}</td>

    <!-- Aksi -->
    <td class="py-3 px-4">
        <form action="{{ route('owner.transaksi.hapus', $row->Id_Cart) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="bg-red-500 text-white px-3 py-1 rounded-full hover:bg-red-600 transition">
        Hapus
    </button>
</form>

    </td>

</tr>
@empty
<tr>
    <td colspan="7" class="py-6 text-center text-gray-500">Belum ada data transaksi</td>
</tr>
@endforelse
          </tbody>

        </table>
      </div>

    </main>
  </div>

  <footer class="py-4 text-center text-gray-500 text-sm mt-auto">
    © {{ date('Y') }} Mie Pansit Gajah Siantar.
  </footer>

</body>
</html>
