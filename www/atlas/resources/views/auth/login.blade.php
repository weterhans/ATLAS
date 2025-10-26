<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perum LPPNPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        // Konfigurasi warna kustom AirNav
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'airnav-blue': '#255A9B',
                        'airnav-red': '#D92D20',
                        'indigo-600': '#255A9B', // Menggunakan warna biru AirNav untuk tombol
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom styles for the page */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-airnav-blue">

    <div id="main-content" class="transition-opacity duration-1000 ease-in-out">
        <div class="min-h-screen flex flex-col items-center justify-center p-4">
            <div class="w-full max-w-sm bg-white rounded-2xl shadow-lg p-8">
                <img src="{{ asset('img/airnav.ico') }}" alt="Logo AirNav Indonesia" class="w-24 h-24 mx-auto mb-4 object-contain" onerror="this.onerror=null;this.src='https://placehold.co/96x96/255A9B/FFFFFF?text=AirNav';">
                <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">Selamat Datang</h1>
                <p class="text-center text-gray-500 mb-8">Silakan masuk ke Dashboard AirNav</p>

                @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm" role="alert">
                    {{ $errors->first() }}
                </div>
                @endif

                @if (session('success'))
                <div id="success-toast"
                    class="fixed top-5 right-5 p-4 rounded-lg bg-green-100 text-green-700 text-sm shadow-lg 
                            transition-all duration-300 ease-in-out 
                            opacity-0 transform translate-x-10"
                    role="alert">
                    {{ session('success') }}
                </div>
                @endif

                <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent" placeholder="Masukkan username" required>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent" placeholder="Masukkan password" required>
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-blue-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Login
                        </button>
                    </div>
                </form>
                <p id="login-error" class="text-red-500 text-center mt-4 hidden">Username atau Password tidak boleh kosong.</p>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" id="register-link" class="font-medium text-airnav-blue hover:text-blue-800">
                            Register disini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="custom-alert" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-sm text-center">
            <p id="alert-message" class="text-gray-700 mb-6">Ini adalah pesan notifikasi.</p>
            <button id="alert-close-btn" class="bg-indigo-600 hover:bg-blue-800 text-white font-medium py-2 px-6 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                OK
            </button>
        </div>
    </div>

    <script src="{{ asset('js/renderer_login.js') }}"></script>

</body>

</html>