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
    <header class="relative w-full">
        <img src="{{ asset('image/5.jpeg') }}" alt="Background" class="w-full h-48 object-cover">
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('image/fix.png') }}" alt="Logo"
                class="w-20 h-20 rounded-full ring-4 ring-white shadow-lg mb-2 object-cover">
            <h1 class="text-2xl font-extrabold text-white tracking-wide drop-shadow-lg">Kasir - Mie Pansit Gajah</h1>
        </div>
    </header>

    <!-- pesanan masuk dri cust -->
    <main class="mt-8 flex flex-col items-center">
        <h2 class="text-xl font-bold text-blue-700">Selamat Datang, Kasir!</h2>
        <p class="text-gray-600 mt-2 text-sm text-center px-6">Gunakan menu di bawah untuk mengelola pesanan pelanggan.</p>

        <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 px-6 max-w-5xl">
            @for ($i = 0; $i < 4; $i++)
            <div class="bg-white rounded-2xl p-4 shadow hover:shadow-blue-200 hover:scale-105 transition text-center backdrop-blur-md">
                <img src="{{ asset('image/4.jpeg') }}" class="w-full h-32 object-cover rounded-xl mb-2">
                <h3 class="font-semibold text-gray-800 text-sm">Pesanan {{ $i+1 }}</h3>
                <p class="text-gray-500 text-xs mb-2">Status: Menunggu</p>
                <button class="bg-blue-500 text-white text-sm py-1.5 px-4 rounded-lg hover:bg-blue-400 transition">
                    Lihat Detail
                </button>
            </div>
            @endfor
        </div>
    </main>

    <!-- nav bawah -->
    <nav class="fixed bottom-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-[0_-4px_10px_rgba(0,0,0,0.1)] py-3 px-8 flex justify-around items-center z-50">

        <!-- menu -->
        <a href="{{ route('kasir.menu') }}"
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
