<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan | Mie Pansit Gajah Siantar</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-200 font-sans text-gray-800 min-h-screen flex flex-col">

    <header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
        <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
            <img src="{{ asset('image/fix.png') }}" 
                alt="Logo" 
                class="w-full h-full object-cover">
        </div>

        <div>
            <h1 class="text-xl font-bold tracking-wide">Detail Pesanan</h1>
            <p class="text-white/80 text-sm">{{ $nama }} | Nomor Meja : {{ $meja }}</p>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto px-5 py-4 space-y-4">
        <div class="max-w-3xl mx-auto px-4 py-6">
            
            @foreach ($cart as $item)
            <div class="bg-white mb-4 rounded-2xl p-4 flex items-center justify-between shadow-sm">

                <div class="flex items-center mb-0 gap-3"> <img src="{{ asset('product/' . DB::table('product')->where('Id_Product', $item['product_id'])->value('Image')) }}"
                        class="w-16 h-16 rounded-xl object-cover">

                    <div>
                        <p class="font-semibold text-gray-800">
                            {{ DB::table('product')->where('Id_Product', $item['product_id'])->value('Nama_Product') }}
                        </p>
                        <p class="text-sm text-gray-700">
                            Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="bg-yellow-300 text-sm font-semibold px-4 py-1 rounded-full">
                    {{ $item['qty'] }}
                </div>

            </div>
            @endforeach

            <div class="bg-white rounded-2xl p-4 shadow-sm space-y-2 text-sm font-semibold text-gray-700">
                
                <p>Nomor Pesanan: #{{ $payment->Id_Cart }}</p>
                <p>Waktu Pemesanan: {{ $payment->Waktu_Bayar }}</p>
                <p>Metode Pembayaran: {{ ucfirst($payment->Metode) }}</p>
                <p>Catatan Tambahan: <span class="font-normal italic">{{ $payment->Catatan ?? '-' }}</span></p>
                
                <div class="flex gap-1">
                    <span>Kasir :</span>
                    @if($payment->Status == 'menunggu')
                        <span class="italic font-normal text-gray-500">Menunggu konfirmasi...</span>
                    @elseif(!empty($payment->NamaKasir))
                        <span class="font-bold text-blue-600 uppercase">{{ $payment->NamaKasir }}</span>
                    @else
                        <span>-</span>
                    @endif
                </div>

                <hr class="border-gray-200 my-2">
                
                <p class="text-base text-gray-900">Total Pesanan: Rp{{ number_format($payment->Jumlah_Bayar,0,',','.') }}</p>
            </div>
        </div>
    </main>

    <footer class="bg-blue-500 text-white text-center py-4 font-semibold shadow">
        Status Pesanan: 
        <span class="text-yellow-300 uppercase tracking-wide">{{ ucfirst($payment->Status) }}</span>
    </footer>

</body>
</html>