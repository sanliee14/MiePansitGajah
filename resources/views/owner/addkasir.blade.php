<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Akun Kasir | Mie Pansit Gajah Siantar</title>
  @vite('resources/css/app.css')
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>

<body class="bg-gradient-to-b from-blue-100 via-blue-200 to-white min-h-screen flex flex-col text-gray-800">

  <!-- Navbar -->
  <header class="bg-blue-500 text-white py-4 px-6 shadow-md flex items-center gap-4">
      <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/70 shadow">
          <img src="{{ asset('image/fix.png') }}" class="w-full h-full object-cover">
      </div>
      <h1 class="text-xl font-bold uppercase tracking-wide">Buat Akun Kasir</h1>

    <a href="{{ route('owner.dashboard') }}"
    class="ml-auto bg-yellow-400 text-blue-900 font-semibold px-4 py-2 rounded-full shadow-md hover:bg-yellow-500 transition">
    Back
    </a>
  </header>

  <!-- FORM CONTAINER -->
  <div class="flex justify-center items-center flex-1 px-4">
    <div class="bg-white shadow-2xl rounded-3xl p-8 w-full max-w-lg border border-blue-100">

      <h2 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-400 
                 text-transparent bg-clip-text mb-6 text-center">
        Registrasi Kasir Baru
      </h2>

      @if ($errors->any())
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <!-- FORM -->
      <form action="{{ route('owner.storekasir') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Nama Kasir -->
        <div class="mb-5">
          <label class="block font-semibold mb-2 text-blue-800">Nama Lengkap</label>
          <input type="text" name="Nama_Kasir" required
            placeholder="Contoh: Arif "
            class="w-full border border-blue-200 rounded-lg p-3 focus:outline-none 
                   focus:ring-2 focus:ring-blue-400 shadow-sm">
        </div>

        <!-- Username -->
        <div class="mb-5">
          <label class="block font-semibold mb-2 text-blue-800">Username</label>
          <input type="text" name="Username" required
            placeholder="Contoh: kasir01"
            class="w-full border border-blue-200 rounded-lg p-3 focus:outline-none 
                   focus:ring-2 focus:ring-blue-400 shadow-sm">
        </div>

        <!-- Password -->
        <div class="mb-5">
          <label class="block font-semibold mb-2 text-blue-800">Password</label>
          <input type="password" name="Password" required
            placeholder="Minimal 6 karakter"
            class="w-full border border-blue-200 rounded-lg p-3 focus:outline-none 
                   focus:ring-2 focus:ring-blue-400 shadow-sm">
        </div>

        <!-- Nomor HP -->
        <div class="mb-8">
          <label class="block font-semibold mb-2 text-blue-800">Nomor HP</label>
          <input type="text" name="Kontak_Kasir" required
            placeholder="Contoh: 081234567890"
            class="w-full border border-blue-200 rounded-lg p-3 focus:outline-none 
                   focus:ring-2 focus:ring-blue-400 shadow-sm">
        </div>

        <button type="submit"
          class="w-full bg-gradient-to-r from-blue-600 to-blue-400 text-white py-3 
                 rounded-full font-semibold shadow-md hover:scale-[1.02] transition-all duration-200">
          Buat Akun Kasir
        </button>
      </form>

    </div>
  </div>

  <footer class="py-4 text-center text-gray-500 text-sm mt-auto">
    © {{ date('Y') }} Mie Pansit Gajah Siantar. Semua hak dilindungi.
  </footer>

</body>
</html>
