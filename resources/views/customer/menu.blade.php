<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Makanan | Mie Pansit Gajah Siantar</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-blue-200 font-sans text-gray-800 relative min-h-screen">

    <header class="relative w-full">
        <img src="{{ asset('image/5.jpeg') }}" alt="Background" class="w-full h-52 object-cover">
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('image/fix.png') }}" alt="Logo"
                class="w-20 h-20 rounded-full ring-4 ring-white shadow-lg mb-2 object-cover">
            <h1 class="text-2xl font-extrabold text-white tracking-wide drop-shadow-lg">Mie Pansit Gajah Siantar</h1>

            <div class="mt-4 flex items-center bg-white/90 rounded-full shadow-lg overflow-hidden w-80 sm:w-96">
                <input type="text" placeholder="Cari menu..."
                    class="flex-1 px-4 py-2 focus:outline-none bg-transparent text-gray-700">
                <button class="px-4 bg-blue-500 text-white hover:bg-blue-400 transition">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </header>

<nav class="relative z-30 flex justify-center mt-6 px-4">
        <div class="bg-blue-100/70 backdrop-blur-md p-3 rounded-full shadow-lg flex flex-wrap justify-center gap-2 sm:gap-4 w-fit border border-white/40">
            
            <a href="{{ route('customer.menu') }}" 
               class="px-5 py-2 rounded-full font-bold text-sm transition-all duration-300 transform hover:scale-105 shadow-sm
               {{ request()->routeIs('customer.menu') || request()->routeIs('cust.home') 
                  ? 'bg-blue-600 text-white ring-2 ring-blue-300 shadow-blue-500/50' 
                  : 'bg-white text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
               All Foods
            </a>

            <a href="{{ route('customer.fav') }}" 
               class="px-5 py-2 rounded-full font-bold text-sm transition-all duration-300 transform hover:scale-105 shadow-sm
               {{ request()->routeIs('customer.fav') 
                  ? 'bg-blue-600 text-white ring-2 ring-blue-300 shadow-blue-500/50' 
                  : 'bg-white text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
               Favorite
            </a>

            <a href="{{ route('customer.makanan') }}" 
               class="px-5 py-2 rounded-full font-bold text-sm transition-all duration-300 transform hover:scale-105 shadow-sm
               {{ request()->routeIs('customer.makanan') 
                  ? 'bg-blue-600 text-white ring-2 ring-blue-300 shadow-blue-500/50' 
                  : 'bg-white text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
               Makanan
            </a>

            <a href="{{ route('customer.minuman') }}" 
               class="px-5 py-2 rounded-full font-bold text-sm transition-all duration-300 transform hover:scale-105 shadow-sm
               {{ request()->routeIs('customer.minuman') 
                  ? 'bg-blue-600 text-white ring-2 ring-blue-300 shadow-blue-500/50' 
                  : 'bg-white text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
               Minuman
            </a>

        </div>
    </nav>

    <main class="flex mt-6 px-8 justify-center gap-8 pb-32"> 
    <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-6xl w-full">

        @foreach ($product as $p)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition 
                    p-4 flex flex-col">

            <!-- Gambar produk -->
            <div class="w-full h-48 rounded-xl overflow-hidden bg-gray-100 mb-3">
                <img src="{{ asset('product/' . $p->Image) }}" 
                    class="w-full h-full object-cover">
            </div>

            <!-- Info produk -->
            <h2 class="font-bold justify-center text-center text-gray-800 text-sm line-clamp-2 mb-1">
                {{ $p->Nama_Product }}
            </h2>

            <p class="text-gray-600 font-bold text-center text-xs mb-3">
                Rp{{ number_format($p->Harga, 0, ',', '.') }}
            </p>

            <!-- Tombol -->
            <button class="add-to-cart w-full bg-blue-500 text-white text-sm py-2 rounded-lg hover:bg-blue-600 transition mt-auto"
                data-id="{{ $p->Id_Product }}" 
                data-name="{{ $p->Nama_Product }}" 
                data-price="{{ $p->Harga }}">

                <i class="fas fa-cart-plus mr-1"></i> Pesan
            </button>
        </div>
        @endforeach

    </section>
</main>


    <div class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md shadow-[0_-4px_10px_rgba(0,0,0,0.1)] px-6 py-3 flex items-center justify-between z-40">
        <div class="flex items-center gap-4">
            <div class="relative">
                <i class="fas fa-shopping-cart text-2xl text-blue-600"></i>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 rounded-full">0</span>
            </div>
            <div>
                <p class="text-gray-600 text-xs leading-tight">Total</p>
                <p id="cart-total" class="text-lg font-bold text-gray-800">Rp0</p>
            </div>
        </div>
        <a href="{{ route('customer.checkout') }}" class="bg-blue-500 hover:bg-blue-400 text-white font-semibold px-6 py-2 rounded-full shadow transition">Checkout</a>
    </div>

    <script src="https://kit.fontawesome.com/a2e0a6c5f6.js" crossorigin="anonymous"></script>
<script>
        // Update function untuk handle tombol Add to Cart
        document.addEventListener('click', function(e) {
            if (e.target.closest('.add-to-cart')) {
                const btn = e.target.closest('.add-to-cart');
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const price = parseInt(btn.dataset.price);

                // Kirim ke backend via AJAX (Fetch) agar session tersimpan
                fetch('{{ route("customer.cart") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id,
                        name: name,
                        price: price
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Update tampilan keranjang berdasarkan respon server
                    document.getElementById('cart-count').innerText = data.count;
                    document.getElementById('cart-total').innerText = 'Rp' + data.total.toLocaleString('id-ID');
                })
                .catch(error => console.error('Error:', error));
            }
        });
    </script>
</body>
</html>