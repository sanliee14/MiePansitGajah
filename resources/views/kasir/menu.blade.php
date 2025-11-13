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

    <!-- header -->
    <header class="relative w-full">
        <img src="{{ asset('image/5.jpeg') }}" alt="Background" class="w-full h-48 object-cover">
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('image/fix.png') }}" alt="Logo"
                class="w-20 h-20 rounded-full ring-4 ring-white shadow-lg mb-2 object-cover">
            <h1 class="text-2xl font-extrabold text-white tracking-wide drop-shadow-lg">Kasir - Mie Pansit Gajah</h1>
        </div>
    </header>

    <!-- kotak pilihan menu -->
    <nav class="relative z-30 flex justify-center mt-6">
    <div class="bg-blue-100/70 backdrop-blur-md p-4 px-6 rounded-3xl shadow-lg flex gap-10 justify-center items-center w-fit">
    
    <!-- pilihan menu -->
    <a href="{{ route('customer.fav') }}" class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
        <i class="fas fa-thumbs-up text-xl"></i>
        <span class="text-xs font-semibold mt-1">Favorit</span>
    </a>

    <a href="{{ route('customer.makanan') }}" class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
        <i class="fas fa-utensils text-xl"></i>
        <span class="text-xs font-semibold mt-1">Makanan</span>
    </a>

    <a href="{{ route('customer.minuman') }}" class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
        <i class="fas fa-coffee text-xl"></i>
        <span class="text-xs font-semibold mt-1">Minuman</span>
    </a>
</div>
</nav>

    <!-- menu makanan -->
    <main class="flex mt-6 px-8 justify-center gap-8 pb-32"> 
        <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 max-w-6xl">
            @for ($i = 0; $i < 8; $i++)
            <div class="backdrop-blur-xl bg-white rounded-2xl p-3 shadow hover:shadow-blue-200 hover:scale-105 transition text-center">
                <img src="{{ asset('image/4.jpeg') }}" class="w-full h-36 object-cover rounded-xl mb-2">
                <h2 class="font-semibold text-gray-800 text-sm">Mie Pansit</h2>
                <p class="text-gray-500 text-xs mb-2">Rp25.000</p>
                <button data-price="25000" class="add-to-cart w-full bg-blue-500 text-white text-sm py-1.5 rounded-lg hover:bg-blue-400 transition">
                    <i class="fas fa-cart-plus mr-1"></i>Pesan
                </button>
            </div>
            @endfor
        </section>
    </main>

    <!-- nav bawah -->
    <nav class="fixed bottom-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-[0_-4px_10px_rgba(0,0,0,0.1)] py-3 px-8 flex justify-around items-center z-50">

        <!-- menu-->
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
