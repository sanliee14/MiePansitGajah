<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir | Mie Pansit Gajah Siantar</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-blue-100 font-sans text-gray-800 relative min-h-screen pb-24">

    <!-- Header -->
    <nav class="bg-blue-500 text-white flex justify-between items-center px-6 py-3 shadow-lg">
    <div class="flex items-center space-x-3">
      <div class="relative w-10 h-10">
        <div class="absolute inset-0 bg-blue-400 blur-xl opacity-40 rounded-full"></div>
        <img src="{{ asset('image/fix.png') }}" alt="Logo" class="relative w-10 h-10 rounded-full ring-2 ring-white/70">
      </div>
      <h1 class="text-xl font-bold uppercase tracking-wide">Pesanan Masuk</h1>
    </div>
  </nav>
    </header>

    <!-- pesanan masuk dri cust -->
<main class="p-5">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-blue-100 mb-5 transition hover:shadow-blue-200">
            <!-- ID + TOTAL -->
            <div class="bg-yellow-100 px-5 py-3 flex justify-between items-center font-bold text-gray-700">
                <span>ID : OPXTYTFH099</span>
                <span>Total : <span class="text-blue-600">Rp175.000</span></span>
            </div>

            <!-- NAMA + MEJA + DETAIL -->
            <div class="bg-blue-500 px-5 py-4 text-white flex justify-between items-center">

                <div class="leading-tight">
                    <p class="text-lg font-bold">Nama Pemesan</p>
                    <p class="text-sm opacity-90">No Meja</p>
                </div>

                <a href="{{ url('/kasir/detailpesanan') }}"
                    class="bg-yellow-400 text-black px-5 py-2.5 rounded-xl font-semibold shadow hover:bg-yellow-500 hover:scale-105 transition">
                    Detail
                </a>
            </div>
        </div>
    </main>

    <!-- nav bawah -->
    <nav class="fixed bottom-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-[0_-4px_10px_rgba(0,0,0,0.1)] py-3 px-8 flex justify-around items-center z-50">

        <!-- menu -->
        <a href="{{ route('kasir.dashboard') }}"
        class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
            <i class="fas fa-utensils text-xl"></i>
            <span class="text-xs font-semibold mt-1">Menu</span>
        </a>

        <!-- acc pesanan -->
        <a href="{{ route('kasir.accpesanan') }}"
        class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
            <i class="fas fa-check-circle text-xl"></i>
            <span class="text-xs font-semibold mt-1">Acc</span>
        </a>

        <!-- diproses -->
        <a href="{{ route('kasir.prosespesanan') }}"
        class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
            <i class="fas fa-hourglass-half text-xl"></i>
            <span class="text-xs font-semibold mt-1">Proses</span>
        </a>

        <!-- history -->
        <a href="{{ route('kasir.history') }}"
        class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
            <i class="fas fa-history text-xl"></i>
            <span class="text-xs font-semibold mt-1">History</span>
        </a>
    </nav>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a2e0a6c5f6.js" crossorigin="anonymous"></script>

</body>
</html>
