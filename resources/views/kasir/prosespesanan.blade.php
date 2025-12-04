<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir | Mie Pansit Gajah Siantar</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-blue-100 font-sans text-gray-800 relative min-h-screen pb-24">

    <!-- Header -->
    <header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
        <img src="{{ asset('image/fix.png') }}" 
            alt="Logo" 
            class="w-full h-full object-cover">
    </div>

        <div>
            <h1 class="text-xl font-bold tracking-wide">Pesanan Diproses</h1>
            <p class="text-white/80 text-sm">Daftar pesanan aktif pelanggan</p>
        </div>
    </nav>
</header>

    <!-- List Pesanan -->
    <main class="p-5">
        <div class="max-w-3xl mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto px-4 py-6">
        @foreach ($order as $psn)
        <a href="{{ route('kasir.detailproses', $psn->Id_Cart) }}">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-blue-100 mb-5 transition hover:shadow-blue-200">

            <!-- ID + TOTAL -->
            <div class="bg-white px-5 py-3 flex justify-between items-center font-bold text-gray-700">
                <span>ID : {{ $psn->Id_Cart }}</span>

                <span>Total :
                    <span class="text-blue-600">
                        Rp{{ number_format($psn->Jumlah_Bayar, 0, ',', '.') }}
                    </span>
                </span>
            </div>

            <!-- NAMA + MEJA + STATUS -->
            <div class="bg-blue-500 px-5 py-4 text-white flex justify-between items-center">

                <div class="leading-tight">
                    <p class="text-lg font-bold">{{ $psn->Nama }}</p>
                    <p class="text-sm opacity-90">Meja : {{ $psn->No_Meja ?? '-' }}</p>
                </div>

                <span class="px-6 py-2.5 rounded-xl font-bold text-black bg-white  shadow-[0_4px_10px_rgba(0,0,0,0.2)] transform hover:scale-105 transition">
                    {{ strtoupper($psn->Status) }}
                </span>

            </div>

        </div>
        </a>
        @endforeach
</div>
</div>
    </main>

    <!-- nav bawah -->
    <nav class="fixed bottom-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-[0_-4px_10px_rgba(0,0,0,0.1)] py-3 px-8 flex justify-around items-center z-50">

        <a href="{{ route('kasir.dashboard') }}" class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
            <i class="fas fa-utensils text-xl"></i>
            <span class="text-xs font-semibold mt-1">Menu</span>
        </a>

        <a href="{{ route('kasir.accpesanan') }}" class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
            <i class="fas fa-check-circle text-xl"></i>
            <span class="text-xs font-semibold mt-1">Acc</span>
        </a>

        <a href="{{ route('kasir.prosespesanan') }}" class="flex flex-col items-center text-white bg-blue-500 transition rounded-full w-16 h-16 shadow-md justify-center">
            <i class="fas fa-hourglass-half text-xl"></i>
            <span class="text-xs font-semibold mt-1">Proses</span>
        </a>

        <a href="{{ route('kasir.history') }}" class="flex flex-col items-center text-blue-600 hover:text-white hover:bg-blue-500 transition rounded-full w-16 h-16 bg-white shadow-md justify-center">
            <i class="fas fa-history text-xl"></i>
            <span class="text-xs font-semibold mt-1">History</span>
        </a>

    </nav>

    <script src="https://kit.fontawesome.com/a2e0a6c5f6.js" crossorigin="anonymous"></script>

</body>
</html>
