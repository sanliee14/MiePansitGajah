<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk | Mie Pansit Gajah Siantar</title>
  @vite('resources/css/app.css')
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

    <a href="{{ url('/') }}"
      class="ml-auto bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition">
      Logout
    </a>
  </nav>
</header>

  <div class="flex flex-1">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-400 text-white min-h-screen p-6 shadow-xl">
      <h2 class="text-xl font-bold mb-6 text-white/90 uppercase tracking-wide">Menu Owner</h2>
      <ul class="space-y-4">
        <li><a href="{{ route('owner.dashboard') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> Dashboard</a></li>
        <li><a href="{{ route('owner.transaksi') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> Data Transaksi</a></li>
        <li><a href="{{ route('owner.product') }}" class="block bg-blue-500 py-2 px-3 rounded-full text-lg font-bold text-center shadow hover:bg-blue-600 transition"> Product & Harga</a></li>
        <li><a href="{{ route('owner.laporan') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> Laporan Harian</a></li>
        <li><a href="{{ route('owner.tambahproduct') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> Tambah Produk</a></li>
        <li><a href="{{ route('owner.addkasir') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> Buat Akun Kasir</a></li>
        <li><a href="{{ route('owner.listkasir') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition"> List Akun Kasir</a></li>
      </ul>
    </aside>

    <!-- Konten Edit Produk -->

    <main class="flex-1 p-10">
<h2 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text mb-10">
        Edit Produk
      </h2>

    <div class="max-w-3xl mx-auto px-4 py-6">
      
      <div class="bg-white p-8  rounded-3xl shadow-lg border border-blue-100 max-w-xl">

        <!-- Gambar sebelumnya -->
        <div class="mb-5">
          <p class="font-semibold text-gray-700 mb-2">Gambar Produk Saat Ini:</p>
          <img src="{{ asset('image/default.png') }}" class="w-40 h-40 object-cover rounded-xl shadow">
        </div>

        <!-- Form Edit -->
        <form action="{{ route('owner.updateproduct', $product->Id_Product) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label class="font-semibold text-gray-700">Nama Produk</label>
        <input type="text" name="Nama_Product" value="{{ $product->Nama_Product }}"
               class="w-full mt-2 p-3 rounded-xl border border-blue-200 focus:ring focus:ring-blue-300 outline-none">
    </div>

    <div>
        <label class="font-semibold text-gray-700">Harga Produk</label>
        <input type="number" name="Harga" value="{{ $product->Harga }}"
               class="w-full mt-2 p-3 rounded-xl border border-blue-200 focus:ring focus:ring-blue-300 outline-none">
    </div>

    <div>
        <label class="font-semibold text-gray-700">Ganti Gambar (Opsional)</label>
        <input type="file" name="Image"
               class="w-full mt-2 p-3 rounded-xl border border-blue-200 bg-white focus:ring focus:ring-blue-300 outline-none">
    </div>

    <div class="flex justify-between mt-8">
        <a href="{{ url('/owner/product') }}"
           class="bg-gray-400 text-white px-5 py-2 rounded-xl shadow hover:bg-gray-500 transition">
           Kembali
        </a>

        <button type="submit"
                class="bg-yellow-400 text-white px-5 py-2 rounded-xl shadow hover:bg-yellow-500 transition">
            Simpan Perubahan
        </button>
    </div>
</form>
</div>
    </main>
  </div>

  <footer class="py-4 text-center text-gray-500 text-sm mt-auto">
    © {{ date('Y') }} Mie Pansit Gajah Siantar. Semua hak dilindungi.
  </footer>

</body>
</html>
