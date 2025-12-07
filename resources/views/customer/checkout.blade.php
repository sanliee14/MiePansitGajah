<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran | Mie Pansit Gajah Siantar</title>
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
        <h1 class="text-lg font-bold">Pesanan Anda</h1>
        <p class="text-sm">{{ $nama }} | Nomor Meja : {{ $meja }}</p>
    </div>
</header>

<!-- Konten Pesanan -->
<main class="flex-1 overflow-y-auto px-5 py-4 space-y-4">
    <div class="max-w-3xl mx-auto px-4 py-6">
        @foreach ($cart as $c)
        <nav class="bg-white mb-4 rounded-2xl p-4 relative" id="item-{{ $c['product_id'] }}">
            <div>
                <a href="{{ route('customer.menu') }}"
                   class="absolute top-3 right-4 text-sm font-semibold text-blue-800 hover:text-blue-600">
                    Tambah Pesanan
                </a>

                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('product/' . DB::table('product')->where('Id_Product', $c['product_id'])->value('Image')) }}"
                             class="w-16 h-16 rounded-xl object-cover">

                        <div>
                            <p class="font-semibold text-gray-800">{{ $c['name'] }}</p>
                            <p class="text-sm text-gray-700">Rp{{ number_format($c['price'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- PLUS MINUS -->
                    <div class="flex items-center gap-3">
                        <button class="btn-minus bg-yellow-400 text-black font-bold w-7 h-7 rounded-full flex items-center justify-center"
                                data-id="{{ $c['product_id'] }}">−</button>

                        <div id="qty-{{ $c['product_id'] }}"
                             class="bg-yellow-300 text-sm font-semibold px-3 py-1 rounded-full">
                            {{ $c['qty'] }}
                        </div>

                        <button class="btn-plus bg-yellow-400 text-black font-bold w-7 h-7 rounded-full flex items-center justify-center"
                                data-id="{{ $c['product_id'] }}">+</button>
                    </div>
                </div>
            </div>
        </nav>
        @endforeach

        <!-- Catatan -->
        <div class="bg-white mb-4 rounded-2xl p-4">
            <label class="block text-sm font-semibold mb-1">Catatan Tambahan</label>
            <textarea 
                name="catatan" 
                id="catatan"
                class="w-full bg-blue-100 rounded-lg p-2 text-sm border-none focus:ring-2 focus:ring-blue-400"
                placeholder="Contoh: tanpa sambal, bungkus terpisah..."></textarea>
        </div>

        <!-- Pembayaran -->
        <div class="bg-white rounded-2xl p-4 flex justify-between items-center font-semibold">
            <span>Pilihan Pembayaran</span>
            <select id="payment-method" class="bg-transparent font-semibold text-right focus:outline-none">
                <option value="cash">Cash</option>
                <option value="qris">Qris</option>
            </select>
        </div>
    </div>
</main>

<!-- Footer Total -->
<footer class="bg-blue-500 text-white px-6 py-4 flex justify-between items-center shadow">
    <div>
        <p class="text-sm">Total</p>
        <p id="total-display" class="text-lg font-bold">
            Rp{{ number_format($total, 0, ',', '.') }}
        </p>
    </div>

    <!-- Form Bayar: support customer & kasir -->
    <form id="form-bayar" action="{{ $action ?? route('customer.bayar') }}" method="POST">
        @csrf
        <input type="hidden" name="total" id="form-total" value="{{ $total }}">
        <input type="hidden" name="catatan" id="form-catatan">
        <input type="hidden" name="payment_method" id="form-payment">
        <button type="submit" 
            class="bg-yellow-400 hover:bg-yellow-300 text-black font-bold px-6 py-2 rounded-full transition">
            Bayar
        </button>
    </form>
</footer>

<!-- ====== JS UPDATE QTY + REMOVE ====== -->
<script>
document.querySelectorAll('.btn-plus').forEach(btn => {
    btn.addEventListener('click', function () {
        updateQty(this.dataset.id, 'plus');
    });
});

document.querySelectorAll('.btn-minus').forEach(btn => {
    btn.addEventListener('click', function () {
        updateQty(this.dataset.id, 'minus');
    });
});

function updateQty(id, action) {
    fetch("{{ route('customer.cartupdate') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ id: id, action: action })
    })
    .then(res => res.json())
    .then(data => {

        if (data.qty === 0) {
            const row = document.getElementById('item-' + id);
            if (row) row.remove();
        } else {
            const qtyEl = document.getElementById('qty-' + id);
            if (qtyEl) qtyEl.innerText = data.qty;
        }

        // Update tampilan total
        document.getElementById('total-display').innerText =
            "Rp" + data.total.toLocaleString('id-ID');

        // Update hidden input total untuk dikirim ke controller
        const totalInput = document.getElementById('form-total');
        if (totalInput) {
            totalInput.value = data.total;
        }
    });
}

// Kirim catatan & metode pembayaran ke form saat submit
const form = document.getElementById('form-bayar');
form.addEventListener('submit', function() {
    document.getElementById('form-catatan').value  = document.getElementById('catatan').value;
    document.getElementById('form-payment').value = document.getElementById('payment-method').value;
});
</script>
</body>
</html>
