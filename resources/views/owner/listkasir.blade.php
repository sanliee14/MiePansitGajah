<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Kasir | Mie Pansit Gajah Siantar</title>
  @vite('resources/css/app.css')
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>

<body class="bg-gradient-to-b from-blue-100 via-blue-200 to-white min-h-screen">

  <!-- HEADER -->
  <header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4 w-full">
      <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
          <img src="{{ asset('image/fix.png') }}" class="w-full h-full object-cover">
      </div>

      <h1 class="text-xl font-bold uppercase tracking-wide">
          Mie Pansit Gajah Siantar
      </h1>

    <a href="{{ route('owner.dashboard') }}"
    class="ml-auto bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition">
    Back
    </a>
  </header>

  <!-- WRAPPER UNTUK SIDEBAR + CONTENT -->
  <div class="flex flex-1">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-blue-400 text-white min-h-screen p-6 shadow-xl">
        <h2 class="text-xl font-bold mb-6 text-white/90 uppercase tracking-wide">Menu Owner</h2>
        <ul class="space-y-4">
          <li><a href="{{ route('owner.dashboard') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition">Dashboard</a></li>
          <li><a href="{{ route('owner.transaksi') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition">Data Transaksi</a></li>
          <li><a href="{{ route('owner.product') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition">Product & Harga</a></li>
          <li><a href="{{ route('owner.laporan') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition">Laporan Harian</a></li>
          <li><a href="{{ route('owner.tambahproduct') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition">Tambah Produk</a></li>
          <li><a href="{{ route('owner.addkasir') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 text-lg font-semibold hover:text-blue-900 transition">Buat Akun Kasir</a></li>
          <li><a href="{{ route('owner.listkasir') }}" class="block bg-blue-500 py-2 px-3 rounded-full text-lg font-bold text-center shadow hover:bg-blue-600 transition">List Akun Kasir</a></li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text mb-6">
          Daftar Akun Kasir
        </h1>

        <!-- sukses alert -->
        @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4">
          {{ session('success') }}
        </div>
        @endif

        <!-- TABLE -->
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-blue-100">

          <table class="min-w-full bg-blue-500 text-white">
            <thead>
              <tr>
                <th class="py-3 px-4 text-left">Nama Kasir</th>
                <th class="py-3 px-4 text-left">Nomor HP</th>
                <th class="py-3 px-4 text-left">Username</th>
                <th class="py-3 px-4 text-left">Password</th>
                <th class="py-3 px-4 text-left">Aksi</th>
              </tr>
            </thead>
          </table>

          <div class="max-h-[450px] overflow-y-auto">
            <table class="min-w-full bg-white">
              <tbody>
                @forelse ($kasir as $k)
                <tr class="border-b hover:bg-blue-50">
                  <td class="py-3 px-4">{{ $k->Nama_Kasir }}</td>
                  <td class="py-3 px-4">{{ $k->Kontak_Kasir }}</td>
                  <td class="py-3 px-4">{{ $k->Username }}</td>
                  <td class="py-3 px-4">{{ $k->Password }}</td>

                  <td class="py-3 px-4">
                    <form action="{{ route('owner.deletekasir', $k->Id_User) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus kasir ini?');">
                      @csrf
                      @method('DELETE')
                      <button class="bg-red-500 text-white text-sm px-3 py-1 rounded-full hover:bg-red-600 transition">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center text-gray-500 py-4">Belum ada kasir terdaftar.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
    </main>
  </div>

</body>
</html>
