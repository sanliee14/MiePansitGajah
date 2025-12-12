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

        <h1 class="text-xl font-bold uppercase tracking-wide">Riwayat Pesanan</h1>
    </header>

    <!-- FILTER + SEARCH -->
    <div class="max-w-3xl mx-auto px-4 py-6">
        <form action="{{ route('kasir.history') }}" method="GET" class="px-5 mt-4 mb-4 space-y-3">

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Cari (Nama / ID Pesanan)</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="contoh: 1 "
                       class="p-2 w-full rounded-lg border border-gray-300 shadow-sm focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Filter Tanggal</label>
                <input type="date"
                       name="tanggal"
                       value="{{ request('tanggal') }}"
                       class="p-2 w-full rounded-lg border border-gray-300 shadow-sm focus:ring focus:ring-blue-200">
            </div>

            <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-400 text-white font-semibold py-2 rounded-lg shadow transition">
                Terapkan
            </button>
        </form>

        <!-- LIST PESANAN -->
        <main class="px-5 mb-20">

            @forelse ($order as $psn)
            <a href="{{ route('kasir.detailhistory', $psn->Id_Cart) }}">

                <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-blue-100 mb-5 transition hover:shadow-blue-200">

                    <!-- ID + STATUS -->
                    <div class="bg-white px-5 py-3 flex justify-between items-center font-bold text-gray-700">
                        <span>ID Pesanan: #{{ $psn->Id_Cart }}</span>
                        <span class="text-blue-600">{{ ucfirst($psn->Status) }}</span>
                    </div>

                    <!-- DETAIL -->
                    <div class="bg-blue-500 px-5 py-4 text-white flex justify-between items-center">

                        <div class="leading-tight">
                            <p class="text-lg font-bold">{{ $psn->Nama }}</p>
                            <p class="text-sm opacity-90">Meja : {{ $psn->No_Meja ?? '-' }}</p>
                            <p class="text-sm opacity-80">Selesai: {{ $psn->Waktu_Bayar }}</p>
                        </div>

                        <span class="px-4 py-2 rounded-xl font-bold shadow bg-white/20 backdrop-blur-md">
                            Rp{{ number_format($psn->Jumlah_Bayar, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

            </a>
            @empty

            <p class="text-center text-gray-600 mt-10">Tidak ada pesanan selesai pada filter ini.</p>

            @endforelse

        </main>
    </div>

    <!-- NAVBAR BAWAH -->
    <nav class="fixed bottom-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-[0_-4px_10px_rgba(0,0,0,0.1)] py-3 px-8 flex justify-around items-center z-50">

        <!-- MENU -->
        <a href="{{ route('kasir.dashboard') }}"
           class="flex flex-col items-center
           {{ Request::routeIs('kasir.dashboard') ? 'text-white bg-blue-500' : 'text-blue-600 bg-white hover:text-white hover:bg-blue-500' }}
           transition rounded-full w-16 h-16 shadow-md justify-center">
            <i class="fas fa-utensils text-xl"></i>
            <span class="text-xs font-semibold mt-1">Menu</span>
        </a>

        <!-- ACC -->
        <a href="{{ route('kasir.accpesanan') }}"
           class="flex flex-col items-center
           {{ Request::routeIs('kasir.accpesanan') ? 'text-white bg-blue-500' : 'text-blue-600 bg-white hover:text-white hover:bg-blue-500' }}
           transition rounded-full w-16 h-16 shadow-md justify-center">
            <i class="fas fa-check-circle text-xl"></i>
            <span class="text-xs font-semibold mt-1">Acc</span>
        </a>

        <!-- PROSES -->
        <a href="{{ route('kasir.prosespesanan') }}"
           class="flex flex-col items-center
           {{ Request::routeIs('kasir.prosespesanan') ? 'text-white bg-blue-500' : 'text-blue-600 bg-white hover:text-white hover:bg-blue-500' }}
           transition rounded-full w-16 h-16 shadow-md justify-center">
            <i class="fas fa-hourglass-half text-xl"></i>
            <span class="text-xs font-semibold mt-1">Proses</span>
        </a>

        <!-- HISTORY -->
        <a href="{{ route('kasir.history') }}"
           class="flex flex-col items-center
           {{ Request::routeIs('kasir.history') ? 'text-white bg-blue-500' : 'text-blue-600 bg-white hover:text-white hover:bg-blue-500' }}
           transition rounded-full w-16 h-16 shadow-md justify-center">
            <i class="fas fa-history text-xl"></i>
            <span class="text-xs font-semibold mt-1">History</span>
        </a>

    </nav>

    <script src="https://kit.fontawesome.com/a2e0a6c5f6.js" crossorigin="anonymous"></script>

</body>
</html>
