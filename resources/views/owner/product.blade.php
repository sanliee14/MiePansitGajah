<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Produk | Mie Pansit Gajah Siantar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-blue-100 min-h-screen flex flex-col text-gray-800">

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
        <li><a href="{{ url('/owner/dashboard') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900"> Dashboard</a></li>
        <li><a href="{{ url('/owner/transaksi') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900"> Data Transaksi</a></li>
        <li><a href="{{ url('/owner/product') }}" class="block bg-blue-500 py-2 px-3 rounded-full font-semibold text-center shadow"> Produk & Harga</a></li>
        <li><a href="{{ url('/owner/laporan') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900"> Laporan Harian</a></li>
        <li><a href="{{ url('/owner/tambahproduct') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900"> Tambah Produk</a></li>
      </ul>
    </aside>

    <!-- Konten Produk -->
    <main class="flex-1 p-8">
      <h2 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text mb-8">
        Kelola Produk
      </h2>

      @if(session('success'))
    <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

@if(session('error'))
    <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">
        {{ session('error') }}
    </div>
@endif

      <!-- Grid Produk (Static) -->
<section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

@foreach ($product as $p)
<div class="bg-white rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 
            transition p-4 flex flex-col h-[500px]">

    <!-- Foto Produk (Portrait) -->
    <div class="w-full h-[300px] overflow-hidden rounded-xl mb-4 bg-gray-100">
        <img src="{{ asset('product/' . $p->Image) }}"
            class="w-full h-full object-cover object-center">
    </div>

    <!-- Nama -->
    <h2 class="font-bold text-gray-800 text-base text-center mt-2 line-clamp-2 min-h-[48px] px-1">
        {{ $p->Nama_Product }}
    </h2>

    <!-- Harga -->
    <p class="text-blue-600 font-semibold text-center text-sm mb-2">
        Rp {{ number_format($p->Harga, 0, ',', '.') }}
    </p>

    <!-- Tombol -->
    <div class="mt-auto flex flex-col gap-2 w-full">

        <!-- Edit -->
        <a href="{{ route('owner.editproduct', $p->Id_Product) }}"
          class="w-full bg-yellow-400 hover:bg-yellow-500 text-white py-2 rounded-lg text-sm font-semibold shadow-md flex items-center justify-center transition">
            ✏️ Edit Produk
        </a>

        <!-- Hapus -->
        <form action="{{ route('owner.deleteproduct', $p->Id_Product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm font-semibold shadow-md flex items-center justify-center transition">
                🗑️ Hapus
            </button>
        </form>

    </div>
</div>
@endforeach

</section>

    </main>
  </div>

  <footer class="py-4 text-center text-gray-500 text-sm mt-auto">
    © {{ date('Y') }} Mie Pansit Gajah Siantar. Semua hak dilindungi.
  </footer>

</body>
</html>
