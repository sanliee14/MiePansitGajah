<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Order Owner | Mie Pansit Gajah Siantar</title>
    @vite('resources/css/app.css')
    <script src="https://kit.fontawesome.com/a2e0a6c5f6.js" crossorigin="anonymous"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-b from-blue-100 via-blue-200 to-white min-h-screen flex flex-col text-gray-800">

  <!-- NAVBAR -->
<header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
        <img src="{{ asset('image/fix.png') }}" 
            alt="Logo" 
            class="w-full h-full object-cover">
    </div>
    <div>
      <h1 class="text-xl font-bold uppercase">Mie Pansit Gajah Siantar</h1>
    </div>
    <a href="{{ url('/owner/editpesanan') }}" class="ml-auto bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition">
      Back
    </a>
  </nav>
</header>

  <div class="flex flex-1">

    <!-- SIDEBAR -->
    <!-- <aside class="w-64 bg-blue-400 text-white min-h-screen p-6 shadow-xl">
      <h2 class="text-lg font-bold mb-6 uppercase tracking-wide">Menu Owner</h2>
      <ul class="space-y-3">
        <li><a href="{{ route('owner.dashboard') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition">Dashboard</a></li>
        <li><a href="{{ route('owner.transaksi') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition">Data Transaksi</a></li>
        <li><a href="{{ route('owner.product') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition">Produk & Harga</a></li>
        <li><a href="{{ route('owner.laporan') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition">Laporan Harian</a></li>
        <li><a href="{{ route('owner.tambahproduct') }}" class="block py-2 px-3 rounded-full hover:bg-blue-300 hover:text-blue-900 transition">Tambah Produk</a></li>
      </ul>
    </aside> -->

    <!-- PRODUK GRID -->
    <main class="flex-1 p-6 flex justify-center">
      <section class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 h-[360px] gap-6 w-full max-w-6xl">
        @foreach ($product as $p)
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-4 flex flex-col ">

            <div class="w-full h-[260px] overflow-hidden rounded-xl mb-4 bg-gray-100">
                <img src="{{ asset('product/' . $p->Image) }}" class="w-full h-full object-cover" />
            </div>

            <h2 class="font-bold text-gray-800 text-sm text-center line-clamp-2 min-h-[40px] px-1">{{ $p->Nama_Product }}</h2>

            <p class="text-blue-600 font-semibold text-center text-base mb-3">Rp {{ number_format($p->Harga, 0, ',', '.') }}</p>

            <button class="add-to-cart w-full bg-blue-500 text-white text-sm py-2 rounded-full hover:bg-blue-600 mt-auto transition"
                data-id="{{ $p->Id_Product }}"
                data-name="{{ $p->Nama_Product }}"
                data-price="{{ $p->Harga }}">
                <i class="fas fa-cart-plus mr-1"></i> Tambah Pesanan
            </button>
        </div>
        @endforeach
      </section>
    </main>
  </div>

  <!-- CHECKOUT BAR -->
  <form id="add-order-form" method="POST" action="{{ route('owner.addproduct.menu', $IdCart) }}">
    @csrf
    <input type="hidden" name="cartItems" id="cartItems">

    <div class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md shadow-md px-6 py-3 flex items-center justify-between z-50 border-t">
        <div class="flex items-center gap-4">
            <div class="relative">
                <i class="fas fa-shopping-cart text-2xl text-blue-600"></i>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 rounded-full">0</span>
            </div>
            <div>
                <p class="text-gray-600 text-xs leading-tight">Total</p>
                <p id="cart-total" class="text-xl font-bold text-gray-800">Rp0</p>
            </div>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white font-semibold px-6 py-4 rounded-full shadow transition">
            Tambah ke Pesanan
        </button>
    </div>
  </form>

  <script>
    let cartCount = 0;
    let cartTotal = 0;
    let cartItems = [];

    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const price = parseInt(btn.dataset.price);

            cartItems.push({ id, name, price, quantity: 1 });

            cartCount++;
            cartTotal += price;

            document.getElementById('cart-count').innerText = cartCount;
            document.getElementById('cart-total').innerText = 'Rp' + cartTotal.toLocaleString('id-ID');

            document.getElementById('cartItems').value = JSON.stringify(cartItems);
        });
    });
</script>

</body>
</html>