<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan | Kasir</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-blue-100 text-gray-800 font-sans min-h-screen pb-32">

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

<main class="p-5">

<div class="max-w-3xl mx-auto px-4 py-6">
    <!-- ID + TOTAL -->
    <div class="bg-white px-4 py-2 flex justify-between font-bold rounded-xl shadow mb-5">
        <span>ID Pesanan : #{{ $cart->Id_Cart }}</span>
        <span>Total Item : {{ $detail->sum('Qty') }}</span>
    </div>

    <!-- LIST MENU -->
    <div class="space-y-3">
        @foreach($detail as $item)
        <div class="bg-white rounded-2xl p-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <img src="{{ asset('product/' . ($item->Image ?? 'default.png')) }}" 
                    alt="Menu" class="w-16 h-16 rounded-xl object-cover">
                <div>
                    <p class="font-semibold text-gray-800">{{ $item->Nama_Product }}</p>
                    <p class="text-sm text-gray-700">Rp{{ number_format($item->Harga, 0, ',', '.') }}</p>
                </div>
            </div>
            <span class="bg-yellow-300 text-black px-3 py-1 rounded-full font-bold">{{ $item->Qty }}</span>
        </div>
        @endforeach
    </div>

    <!-- INFORMASI TAMBAHAN -->
    <div class="bg-white rounded-2xl mt-4 p-4 space-y-1 text-sm font-semibold shadow-sm">
        <p>Nama : {{ $cart->Nama }}</p>
        <p>Nomor Meja : {{ $cart->No_Meja }}</p>
        <p>Catatan Tambahan: {{ $cart->Catatan ?? '-' }}</p>
        <p>Metode Pembayaran: {{ $cart->Metode ?? '-' }}</p>
        <p>Waktu Pemesanan: {{ $cart->Waktu_Cart ?? '-' }}</p>
        <p>Nomor Pesanan: #{{ $cart->Id_Cart }}</p>
        <p class="sm:col-span-2 font-bold text-blue-700 text-lg mt-2">Total Pesanan: Rp{{ number_format($cart->Total_Harga ?? 0, 0, ',', '.') }}</p>
    </div>

    <!-- TOMBOL -->
    <div class="mt-8">
        <form action="{{ route('kasir.terimapesanan', $cart->Id_Cart) }}" method="POST" class="w-full">
            @csrf
            <button type="submit"
        class="w-full mt-2 bg-blue-500 hover:bg-blue-200 text-white font-bold py-3 rounded-xl shadow-lg transition-all duration-200">
        ✓ Terima
    </button>
            
        </form>
    </div>
</div>
</main>
</body>
</html>
