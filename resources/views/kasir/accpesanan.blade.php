<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acc Pesanan | Mie Pansit Gajah Siantar</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-100 font-sans text-gray-800 min-h-screen pb-24">

<!-- Header -->
<header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
        <img src="{{ asset('image/fix.png') }}" 
            alt="Logo" 
            class="w-full h-full object-cover">
    </div>
        <div>
            <h1 class="text-xl font-bold tracking-wide">Pesanan Masuk</h1>
            <p class="text-white/80 text-sm">Daftar pesanan masuk pelanggan</p>
        </div>
    </nav>
</header>

<!-- Pesanan masuk -->
<main class="p-5">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

        @forelse ($order as $item)

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-blue-100 
                    transition hover:shadow-blue-200">

            <!-- ID + TOTAL -->
            <div class="bg-white px-5 py-3 flex justify-between items-center font-bold text-gray-700">
                <span>ID Pesanan: #{{ $item->Id_Cart }}</span>
                <span>Total:
                    <span class="text-blue-600">Rp{{ number_format($item->Jumlah_Bayar, 0, ',', '.') }}</span>
                </span>
            </div>

            <!-- INFO + BUTTON -->
            <div class="bg-blue-500 px-5 py-4 text-white flex justify-between items-center">
                <div class="leading-tight">
                    <p class="text-xl font-bold">{{ $item->Nama }}</p>
                    <p class="text-lg font-bold">Meja {{ $item->No_Meja }}</p>
                    <p class="text-sm opacity-90">Status: {{ ucfirst($item->Status) }}</p>
                </div>

                <a href="{{ route('kasir.detailpesanan', $item->Id_Cart) }}"
                    class="bg-white text-black px-5 py-2.5 rounded-xl font-bold shadow hover:bg-blue-200 hover:scale-105 transition">
                    Detail
                </a>
            </div>

        </div>

        @empty
            <p class="text-center text-gray-600 font-semibold col-span-2">Belum ada pesanan masuk.</p>
        @endforelse

    </div>
</main>


<!-- Nav bawah -->
<nav class="fixed bottom-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-[0_-4px_10px_rgba(0,0,0,0.1)] py-3 px-8 flex justify-around items-center z-50">

    <a href="{{ route('kasir.dashboard') }}" class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
        <i class="fas fa-utensils text-xl"></i>
        <span class="text-xs font-semibold mt-1">Menu</span>
    </a>

    <!-- ACC (aktif) -->
    <a href="{{ route('kasir.accpesanan') }}" class="flex flex-col items-center text-white bg-blue-500 transition rounded-full w-16 h-16 shadow-md justify-center">
        <i class="fas fa-check-circle text-xl"></i>
        <span class="text-xs font-semibold mt-1">Acc</span>
    </a>

    <a href="{{ route('kasir.prosespesanan') }}" class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
        <i class="fas fa-hourglass-half text-xl"></i>
        <span class="text-xs font-semibold mt-1">Proses</span>
    </a>

    <a href="{{ route('kasir.history') }}" class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
        <i class="fas fa-history text-xl"></i>
        <span class="text-xs font-semibold mt-1">History</span>
    </a>
</nav>

</body>
</html>
