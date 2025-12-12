<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kasir | Menu</title>
@vite('resources/css/app.css')
</head>
<body class="bg-blue-100 font-sans text-gray-800 min-h-screen">

<!-- HEADER -->
<header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
        <img src="{{ asset('image/fix.png') }}" 
            alt="Logo" 
            class="w-full h-full object-cover">
    </div>
    <div>
        <h1 class="text-xl font-bold uppercase tracking-wide">Mie Pansit Gajah Siantar</h1>
    </div>
    <div class="hidden md:flex items-center bg-blue-200 backdrop-blur-lg px-4 py-2 rounded-full shadow-md w-64">
        <i class="fas fa-search text-white/90 mr-2 text-lg"></i>
        <input type="text" placeholder="Cari menu…" class="bg-transparent placeholder-white/80 text-white focus:outline-none w-full text-sm">
    </div>
    <a href="{{ route('logout') }}" class="ml-auto bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition">
        Logout
    </a>
</header>

<!-- SIDEBAR -->
<aside class="fixed top-[80px] left-0 h-full w-32 bg-blue-500 shadow-lg flex flex-col items-center py-6 gap-6 z-40">

  
    <!-- Dashboard -->
    <div class="flex flex-col items-center gap-2">
        <a href="{{ url('/kasir/dashboard') }}" 
           class="w-14 h-14 flex items-center justify-center bg-white rounded-full shadow hover:bg-blue-400 hover:text-white transition">
            <img src="/image/home.jpg" class="w-10 h-10 object-cover rounded-full">
        </a>
        <span class="text-xs font-semibold text-white text-center">Dashboard</span>
    </div>

    <!-- Terima Pesanan -->
    <div class="flex flex-col items-center gap-2">
        <a href="{{ url('/kasir/accpesanan') }}" 
           class="w-14 h-14 flex items-center justify-center bg-white rounded-full shadow hover:bg-blue-400 hover:text-white transition">
            <img src="/image/acc4.jpg" class="w-10 h-10 object-cover rounded-full">
        </a>
        <span class="text-xs font-semibold text-white text-center">Terima Pesanan</span>
    </div>

    <!-- Proses Pesanan -->
    <div class="flex flex-col items-center gap-2">
        <a href="{{ url('/kasir/prosespesanan') }}" 
           class="w-14 h-14 flex items-center justify-center bg-white rounded-full shadow hover:bg-blue-400 hover:text-white transition">
            <img src="/image/proses2.jpg" class="w-10 h-10 object-cover rounded-full">
        </a>
        <span class="text-xs font-semibold text-white text-center">Proses Pesanan</span>
    </div>

    <!-- History -->
    <div class="flex flex-col items-center gap-2">
        <a href="{{ url('/kasir/history') }}" 
           class="w-14 h-14 flex items-center justify-center bg-white rounded-full shadow hover:bg-blue-400 hover:text-white transition">
            <img src="/image/history2.jpg" class="w-10 h-10 object-cover rounded-full">
        </a>
        <span class="text-xs font-semibold text-white text-center">History</span>
    </div>

    <!-- Tambah Produk -->
    <div class="flex flex-col items-center gap-2">
        <a href="{{ url('/kasir/tambahproduct') }}" 
           class="w-14 h-14 flex items-center justify-center bg-white rounded-full shadow hover:bg-blue-400 hover:text-white transition">
            <img src="/image/add2.jpg" class="w-10 h-10 object-cover rounded-full">
        </a>
        <span class="text-xs font-semibold text-white text-center">Tambah Produk</span>
    </div>

</aside>

<!-- MAIN CONTENT -->
<main class="ml-20 md:ml-24 lg:ml-28 p-6 md:p-8 flex justify-center">
    <section class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 w-full max-w-6xl">
        @foreach ($product as $p)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition p-4 flex flex-col">
            <div class="w-full h-48 rounded-xl overflow-hidden bg-gray-100 mb-3">
                <img src="{{ asset('product/' . $p->Image) }}" class="w-full h-full object-cover">
            </div>
            <h2 class="font-bold justify-center text-center text-gray-800 text-sm line-clamp-2 mb-1">{{ $p->Nama_Product }}</h2>
            <p class="text-gray-600 font-bold text-center text-xs mb-3">Rp{{ number_format($p->Harga, 0, ',', '.') }}</p>
            <button class="add-to-cart w-full bg-blue-500 text-white text-sm py-2 rounded-full hover:bg-blue-600 transition mt-auto"
                data-id="{{ $p->Id_Product }}" 
                data-name="{{ $p->Nama_Product }}" 
                data-price="{{ $p->Harga }}">
                <i class="fas fa-cart-plus mr-1"></i> Pesan
            </button>
        </div>
        @endforeach
    </section>
</main>

<!-- CHECKOUT BAR -->
<div class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md shadow-md px-6 py-3 flex items-center justify-between z-50">
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
    {{-- Checkout versi kasir: ke form Nama & Meja --}}
    <a href="{{ route('kasir.data') }}" class="bg-blue-500 hover:bg-blue-400 text-white font-semibold px-6 py-2 rounded-full shadow transition">
        Checkout
    </a>
</div>

<script src="https://kit.fontawesome.com/a2e0a6c5f6.js" crossorigin="anonymous"></script>
<script>
    
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const price = btn.dataset.price;

            fetch("{{ route('customer.cart') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    name: name,
                    price: price
                })
            })
            .then(res => res.json())
            .then(data => {
                // update tampilan jumlah & total
                document.getElementById('cart-count').innerText = data.count;
                document.getElementById('cart-total').innerText =
                    'Rp' + Number(data.total).toLocaleString('id-ID');
            })
            .catch(err => {
                console.error('Error cart:', err);
            });
        });
    });

    // --- ANTI BACK ---
    window.addEventListener("pageshow", function(event) {
        var historyTraversal = event.persisted || 
                               (typeof window.performance != "undefined" && 
                                window.performance.navigation.type === 2);
        if (historyTraversal) {
            window.location.reload();
        }
    });
</script>
</body>
</html>
