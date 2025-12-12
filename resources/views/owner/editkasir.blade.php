<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kasir</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-200 font-sans text-gray-800 min-h-screen p-8 flex items-center justify-center">

    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/50">
        
        <div class="bg-blue-500 px-8 py-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white tracking-wide">Edit & Reset Password Kasir</h1>
            <a href="{{ route('owner.listkasir') }}" class="text-blue-100 hover:text-white text-sm font-semibold transition">
                ← Kembali
            </a>
        </div>

        <form action="{{ route('owner.updatekasir', $data->Id_User) }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Kasir</label>
                <input type="text" name="Nama" value="{{ $data->Nama }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition bg-blue-50/50">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kontak / No. HP</label>
                <input type="text" name="Kontak" value="{{ $data->Kontak_Kasir }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition bg-blue-50/50">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Username Login</label>
                <input type="text" name="Username" value="{{ $data->Username }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition bg-blue-50/50">
            </div>

            <hr class="border-gray-200 my-6">

            <div class="bg-yellow-50 p-5 rounded-xl border border-yellow-200 shadow-sm">
                <label class="block text-gray-800 font-bold mb-1">Reset Password Baru</label>
                <p class="text-xs text-gray-500 mb-3">
                    Biarkan kosong jika tidak ingin mengganti password. Isi jika Kasir lupa password.
                </p>
                <input type="password" name="Password" placeholder="Masukkan password baru (Opsional)"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 outline-none transition bg-white">
            </div>

            <button type="submit" 
                class="w-full bg-blue-500 hover:bg-blue-400 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-blue-300/50 transition-all duration-300 transform hover:-translate-y-1">
                Simpan Perubahan
            </button>
        </form>
    </div>

</body>
</html>