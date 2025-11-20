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

   <nav class="fixed top-1/2 -translate-y-1/2 pl-8">
    <div class="bg-blue-100/70 backdrop-blur-md p-4 px-6 rounded-3xl shadow-lg flex flex-col gap-6 justify-center items-center w-fit">

        <a href="{{ url('/kasir/dashboard') }}"
            class="w-16 h-16 bg-[#3C82F6] rounded-full shadow flex items-center justify-center hover:scale-105 transition">
            <img src="/image/icon1.png" class="w-8">
        </a>

        <a href="{{ url('/kasir/accpesanan') }}"
            class="w-16 h-16 bg-[#3C82F6] rounded-full shadow flex items-center justify-center hover:scale-105 transition">
            <img src="/image/icon2.png" class="w-8">
        </a>

        <a href="{{ url('/kasir/prosespesanan') }}"
            class="w-16 h-16 bg-[#3C82F6] rounded-full shadow flex items-center justify-center hover:scale-105 transition">
            <img src="/image/icon2.png" class="w-8">
        </a>

        <a href="{{ url('/kasir/history') }}"
            class="w-16 h-16 bg-[#3C82F6] rounded-full shadow flex items-center justify-center hover:scale-105 transition">
            <img src="/image/icon3.png" class="w-7">
        </a>
    </div>
</nav>



    <!-- MENU CONTENT -->
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

    <div class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md shadow-[0_-4px_10px_rgba(0,0,0,0.1)] px-6 py-3 flex items-center justify-between z-40">
        <div class="flex items-center gap-4">
            <!-- Icon Cart + Jumlah -->
            <div class="relative">
                <i class="fas fa-shopping-cart text-2xl text-blue-600"></i>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 rounded-full">0</span>
            </div>
            <!-- Total -->
            <div>
                <p class="text-gray-600 text-xs leading-tight">Total</p>
                <p id="cart-total" class="text-lg font-bold text-gray-800">Rp0</p>
            </div>
        </div>

        <!-- Tombol Checkout -->
        <a href="{{ route('customer.checkout') }}" 
        class="bg-blue-500 hover:bg-blue-400 text-white font-semibold px-6 py-2 rounded-full shadow transition">
        Checkout
        </a>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a2e0a6c5f6.js" crossorigin="anonymous"></script>

    <!-- Script Keranjang -->
    <script>
        let cartCount = 0;
        let cartTotal = 0;

        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', () => {
                const price = parseInt(btn.dataset.price);
                cartCount++;
                cartTotal += price;

                document.getElementById('cart-count').innerText = cartCount;
                document.getElementById('cart-total').innerText = 'Rp' + cartTotal.toLocaleString('id-ID');
            });
        });
    </script>
</body>
</html>

