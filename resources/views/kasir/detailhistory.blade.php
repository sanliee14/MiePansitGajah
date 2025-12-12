<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail History | Mie Pansit Gajah Siantar</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-blue-100 font-sans text-gray-800 min-h-screen">

    <!-- HEADER TETAP FULL -->
    <header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
        <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
            <img src="{{ asset('image/fix.png') }}" 
                alt="Logo" 
                class="w-full h-full object-cover">
        </div>
        <div>
            <h1 class="text-xl font-bold tracking-wide">Detail History</h1>
            <p class="text-sm mt-0.5">
                {{ $cart->Nama }} | Nomor Meja : {{ $cart->No_Meja ?? '-' }}
            </p>
        </div>
    </header>

    <!-- WRAPPER KONTEN DENGAN JARAK KIRI-KANAN -->
    <div class="max-w-3xl mx-auto px-4 py-6">
    
        <!-- CARD BESAR -->
<div class="rounded-2xl shadow-xl bg-white overflow-hidden">

    <!-- BAGIAN KUNING / HEADER PUTIH -->
    <div class="bg-white px-5 py-4 flex justify-between font-bold text-gray-800 border-b border-blue-200">
        <span>ID Pesanan : #{{ $cart->Id_Cart }}</span>
        <span class="text-blue-600">{{ ucfirst($cart->Status) }}</span>
    </div>

    <!-- BAGIAN BIRU FULL TANPA PINGGIR -->
    <div class="bg-blue-500 px-5 py-6 space-y-6">

        @foreach ($detail as $item)
            <div class="flex items-center gap-5 p-5 rounded-xl shadow-sm  hover:bg-white/30 transition">
                <img src="{{ asset('product/' . $item->Image) }}"
                    class="w-20 h-20 rounded-xl shadow object-cover">

                <div class="flex flex-col text-white">
                    <p class="font-bold text-lg">{{ $item->Nama_Product }}</p>
                    <p class="text-sm text-blue-100">Rp{{ number_format($item->Harga, 0, ',', '.') }}</p>
                </div>

                <div class="ml-auto bg-yellow-300 text-black px-5 py-1 rounded-full font-bold text-md shadow">
                    {{ $item->Qty }}
                </div>
            </div>
        @endforeach

    </div>
    <!-- TOTAL ITEM -->
<div class="bg-white px-5 py-3 border-t border-blue-200 flex justify-end font-bold text-gray-800">
    Total Item: {{ $detail->sum('Qty') }}
</div>

</div>


        <!-- DETAIL CUSTOMER -->
    <div class="bg-white mt-6 rounded-2xl p-6 shadow-xl space-y-3 border border-blue-200">

    <h2 class="text-lg font-bold text-blue-700 mb-2">Detail Customer</h2>

    <div class="flex flex-col space-y-2 text-gray-700">
        <p><span class="font-semibold">Nama Customer :</span> {{ $cart->Nama }}</p>
        <p><span class="font-semibold">Nomor Meja :</span> {{ $cart->No_Meja }}</p>
        <p><span class="font-semibold">Catatan :</span> {{ $cart->Catatan ?? '-' }}</p>
        <p><span class="font-semibold">Waktu Selesai :</span> {{ $cart->Waktu_Bayar }}</p>
        <p><span class="font-semibold">Metode :</span> {{ $cart->Metode }}</p>
        <p><span class="font-semibold">Kasir :</span> {{ $cart->NamaKasir ?? '-' }}</p>

                <p class="sm:col-span-2 font-bold text-blue-700 text-xl mt-2">
                    Total Harga : Rp{{ number_format($cart->Jumlah_Bayar, 0, ',', '.') }}
                </p>
            </div>
        </div>

    </div> <!-- END WRAPPER -->

</body>

</html>
