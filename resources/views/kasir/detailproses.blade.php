<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan | Mie Pansit Gajah Siantar</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-blue-100 font-sans text-gray-800 min-h-screen flex flex-col">
<header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
        <img src="{{ asset('image/fix.png') }}" 
            alt="Logo" 
            class="w-full h-full object-cover">
    </div>
            <!-- TITLE + INFO -->
            <div class="flex flex-col leading-tight">
                <h1 class="text-xl font-bold">Detail Proses</h1>
                <p class="text-sm mt-0.5">
                    {{ $cart->Nama }} | Nomor Meja : {{ $cart->No_Meja ?? '-' }}
                </p>
            </div>

        </div>
    </nav>
</header>

    <!-- Konten -->
    <main class="flex-1 overflow-y-auto px-6 py-6">
    <div class="max-w-3xl mx-auto px-6 py-8 space-y-6">

        <!-- Daftar Item -->
        @foreach ($detail as $item)
        <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm mb-3">
            <div class="flex items-center gap-4">
                <img src="{{ asset('product/' . $item->Image) }}"
                     alt="Menu"
                     class="w-16 h-16 rounded-xl object-cover">

                <div class="space-y-1">
                    <p class="font-semibold text-gray-800 text-base">
                        {{ $item->Nama_Product }}
                    </p>
                    <p class="text-sm text-gray-700">
                        Rp{{ number_format($item->Harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <span class="bg-yellow-300 text-sm font-semibold px-4 py-1.5 rounded-full">
                {{ $item->Qty }}
            </span>
        </div>
        @endforeach

        <!-- Detail Pesanan -->
        <div class="bg-white rounded-2xl p-5 space-y-2 text-sm font-semibold shadow-sm">
            <p>Total Item : {{ $detail->sum('Qty') }}</p>
            <p>Catatan Tambahan : {{ $cart->Catatan ?? '-' }}</p>
            <p>Metode Pembayaran : {{ $cart->Metode }}</p>
            <p>Waktu Pemesanan : {{ $cart->Waktu_Bayar }}</p>
            <p>Nomor Pesanan : #{{ $cart->Id_Cart }}</p>

            <p class="font-bold text-blue-700 text-lg pt-2">
                Total Pesanan :
                Rp{{ number_format($cart->Total_Harga, 0, ',', '.') }}
            </p>
        </div>

        <!-- Tombol -->
       <form action="{{ route('kasir.selesai', $cart->Id_Cart) }}" method="POST"> @csrf <button type="submit" class="w-full mt-4 bg-blue-500 hover:bg-green-400 text-white font-bold py-3 rounded-xl shadow-lg transition-all duration-200"> ✓ SELESAIKAN PESANAN </button>
        </form>

    </div>
</main>

    <!-- Status -->
    <footer class="bg-blue-500 text-white text-center py-4 font-semibold shadow-[0_-4px_10px_rgba(0,0,0,0.1)]">
        Status Pesanan: 
        <span class="text-yellow-300">{{ $cart->Status }}</span>
    </footer>
</body>
</html> 