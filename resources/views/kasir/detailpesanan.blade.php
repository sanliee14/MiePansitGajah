<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta-name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan | Kasir</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-blue-100 text-gray-800 font-sans min-h-screen pb-32">

<header>
      <nav class="bg-blue-500 text-white flex justify-between items-center px-6 py-3 shadow-lg">
    <div class="flex items-center space-x-3">
      <div class="relative w-10 h-10">
        <div class="absolute inset-0 bg-blue-400 blur-xl opacity-40 rounded-full"></div>
        <img src="{{ asset('image/fix.png') }}" alt="Logo" class="relative w-10 h-10 rounded-full ring-2 ring-white/70">
      </div>
      <h1 class="text-xl font-bold uppercase tracking-wide">Detail Pesanan</h1>
    </div>
  </nav>
    </header>

    <main class="p-5">

        <!-- ID + TOTAL -->
        <div class="bg-blue-200 px-4 py-2 flex justify-between font-semibold rounded-xl shadow mb-5">
            <span>ID : OPXTYTFH099</span>
            <span>Total : Rp175.000</span>
        </div>

        <!-- LIST MENU -->
        <div class="space-y-3">

            <!-- ITEM 1 -->
            <div class="bg-blue-200 rounded-2xl p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('image/4.jpeg') }}" alt="Menu" class="w-16 h-16 rounded-xl object-cover">
                <div>
                    <p class="font-semibold text-gray-800">Nasi Goreng</p>
                    <p class="text-sm text-gray-700">Rp54.000</p>
                </div>
            </div>
                <span class="bg-yellow-300 text-black px-3 py-1 rounded-full font-bold">5</span>
            </div>
        </div>

        <!-- INFORMASI TAMBAHAN -->
        <div class="bg-blue-200 rounded-2xl mt-4 p-4 space-y-1 text-sm font-semibold">
            <p>Nama : </p>
            <p>Nomor Meja :</p>
            <p>Catatan Tambahan: -</p>
            <p>Metode Pembayaran: Cash / Qris</p>
            <p>Waktu Pemesanan: 12:30</p>
            <p>Nomor Pesanan: #12345</p>
            <p>Total Pesanan: Rp104.000</p>
        </div>

    <!-- TOMBOL -->
    <div class="flex justify-center gap-6 mt-8">
    <a href="{{ url('/kasir/prosespesanan') }}"
        class="bg-green-400 text-white px-10 py-3 rounded-xl shadow-lg text-lg font-bold text-center">
        ✔ Terima
    </a>

    <a href="{{ url('/kasir/dashboard') }}"
        class="bg-red-500 text-white px-10 py-3 rounded-xl shadow-lg text-lg font-bold text-center">
        ✖ Tolak
    </a>

</div>


    </main>
</body>
</html>
