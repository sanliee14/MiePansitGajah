<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kasir | Mie Pansit Gajah Siantar</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-blue-200 flex flex-col items-center justify-center min-h-screen font-sans text-gray-800">

    <!-- form login -->
    <div class="bg-white/20 backdrop-blur-lg border border-white/30 rounded-3xl shadow-2xl p-8 w-90 text-center">
        <!-- logo -->
        <div class="flex justify-center mb-4">
            <div class="relative w-20 h-20">
                <img src="{{ asset('image/fix.png') }}" alt="Logo"
                    class="w-full h-full object-cover rounded-full shadow-lg ring-4 ring-white/70">
            </div>
        </div>
        <h1 class="text-2xl font-extrabold tracking-wide uppercase mt-2 mb-6 bg-blue-400 text-transparent bg-clip-text drop-shadow-sm">
            Kasir Mie Pansit Gajah Siantar
        </h1>

        <!-- form username & passowrd -->
        <form action="{{ route('kasir.menu') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="username" placeholder="Username"
                class="w-full px-4 py-3 rounded-xl bg-white/30 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
            
            <input type="password" name="password" placeholder="Password"
                class="w-full px-4 py-3 rounded-xl bg-white/30 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-300">

            <button type="submit"
                class="w-full mt-2 bg-blue-500 hover:bg-blue-400 text-white font-semibold py-3 rounded-full shadow-lg transition-all duration-300 hover:scale-105">
                LOGIN
            </button>
        </form>

        <!-- lupa pass -->
        <p class="text-sm text-gray-700 mt-4">
            Lupa password? <a href="#" class="text-blue-700 hover:underline">Hubungi Owner</a>
        </p>
    </div>

    <p class="absolute bottom-8 text-xs text-gray-800">
        © {{ date('Y') }} Mie Pansit Gajah Siantar. Semua hak dilindungi.
    </p>

</body>
</html>
