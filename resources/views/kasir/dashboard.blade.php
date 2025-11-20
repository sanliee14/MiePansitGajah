<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir | Menu</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-blue-100 font-sans text-gray-800 relative min-h-screen pb-24">

    <!-- HEADER -->
    <header class="relative w-full">
        <nav class="bg-blue-500 text-white flex justify-between items-center px-6 py-3 shadow-lg">
    <div class="flex items-center space-x-3">
        <div class="relative w-10 h-10">
        <div class="absolute inset-0 bg-blue-400 blur-xl opacity-40 rounded-full"></div>
        <img src="{{ asset('image/fix.png') }}" alt="Logo" class="relative w-10 h-10 rounded-full ring-2 ring-white/70">
    </div>
        <h1 class="text-xl font-bold uppercase tracking-wide">Mie Pansit Gajah Siantar</h1>
    </div>
    </nav>
    </header>

    <!-- MENU CONTENT -->
    <main class="px-6 mt-6 pb-28">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">

            <!-- CARD MENU (STATIC 8 ITEM) -->
            @for ($i = 0; $i < 8; $i++)
            <div class="bg-white rounded-2xl shadow hover:shadow-lg p-3 transition hover:scale-105 text-center">
                <img src="{{ asset('image/4.jpeg') }}" class="w-full h-32 object-cover rounded-xl mb-2">
                <h3 class="font-semibold text-gray-800 text-sm">Mie Pansit</h3>
                <p class="text-gray-500 text-xs mb-2">Rp25.000</p>

                <button class="w-full bg-blue-500 text-white text-sm py-1.5 rounded-full hover:bg-blue-400 transition">
                    Pesan
                </button>
            </div>
            @endfor
        </div>
        
        <!-- TOMBOL MENUJU HALAMAN PAYMENT -->
    <div class="fixed bottom-20 left-0 w-full px-6">
    <a href="{{ route('kasir.payment') }}">
        <button class="w-full bg-green-500 text-white font-bold py-3 rounded-2xl shadow-lg hover:bg-green-400 transition">
            Lanjut ke Payment
        </button>
    </a>
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

    <!-- ICON KIT -->
    <script src="https://kit.fontawesome.com/a2e0a6c5f6.js" crossorigin="anonymous"></script>

</body>
