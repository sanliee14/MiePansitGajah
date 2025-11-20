<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran | Mie Pansit Gajah Siantar</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-100 font-sans text-gray-800 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-500 text-white py-4 px-6 shadow-md">
        <h1 class="text-lg font-bold">Pesanan Anda</h1>
        <p class="text-sm">Sanny | Nomor Meja : -</p>
    </header>

    <!-- Konten Pesanan -->
    <main class="flex-1 overflow-y-auto px-5 py-4 space-y-4">

        <!-- Item Pesanan -->
        <div class="bg-blue-200 rounded-2xl p-4 relative">
            <!-- Tombol Tambah Pesanan -->
            <a href="{{ route('customer.order') }}"
            class="absolute top-3 right-4 text-sm font-semibold text-blue-800 hover:text-blue-600">
                Tambah Pesanan
            </a>

            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/4.jpeg') }}" alt="Menu" class="w-16 h-16 rounded-xl object-cover">
                    <div>
                        <p class="font-semibold text-gray-800">Nasi Goreng</p>
                        <p class="text-sm text-gray-700">Rp54.000</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button class="bg-yellow-400 text-black font-bold w-7 h-7 rounded-full flex items-center justify-center">-</button>
                    <span class="bg-yellow-300 text-sm font-semibold px-3 py-1 rounded-full">2</span>
                    <button class="bg-yellow-400 text-black font-bold w-7 h-7 rounded-full flex items-center justify-center">+</button>
                </div>
            </div>
        </div>

        <!-- Catatan -->
        <div class="bg-blue-200 rounded-2xl p-4">
            <label class="block text-sm font-semibold mb-1">Catatan Tambahan</label>
            <textarea class="w-full rounded-lg p-2 text-sm border-none focus:ring-2 focus:ring-blue-400" rows="2"
            placeholder="Contoh: tanpa sambal, bungkus terpisah..."></textarea>
        </div>

        <!-- Pembayaran -->
        <div class="bg-blue-200 rounded-2xl p-4 flex justify-between items-center font-semibold">
            <span>Pilihan Pembayaran</span>
            <select class="bg-transparent font-semibold text-right focus:outline-none">
                <option>Cash</option>
                <option>Qris</option>
            </select>
        </div>
    </main>

    <!-- Footer Total -->
    <footer class="bg-blue-500 text-white px-6 py-4 flex justify-between items-center shadow-[0_-4px_10px_rgba(0,0,0,0.1)]">
        <div>
            <p class="text-sm">Total</p>
            <p class="text-lg font-bold">Rp104.000</p>
        </div>
        <a href="{{ route('customer.qris') }}"
        class="bg-yellow-400 hover:bg-yellow-300 text-black font-bold px-6 py-2 rounded-full transition">
        Bayar
        </a>
    </footer>

</body>
</html>
