<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perum LPPNPI - Cabang Surabaya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ... (konfigurasi tailwind biarin aja) ...
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'airnav-blue': '#255A9B',
                        'airnav-red': '#D92D20',
                        'indigo-600': '#255A9B',
                    }
                }
            }
        }
    </script>
    <style>
        /* ... (Semua style CSS kamu biarin aja) ... */
        body {
            font-family: 'Inter', sans-serif;
        }

        #sidebar,
        #main-content {
            transition: all 0.3s ease-in-out;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        #main-content::-webkit-scrollbar {
            display: none;
        }

        #main-content {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        #sidebar.collapsed .menu-text,
        #sidebar.collapsed #logo-container,
        #sidebar.collapsed #logout-text {
            display: none;
        }

        #sidebar.collapsed .sidebar-header {
            justify-content: center;
        }

        .menu-active {
            background-color: #e5e7eb;
            font-weight: 600;
            color: #1f2937;
        }

        #sidebar.collapsed .nav-link {
            justify-content: center;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800 overflow-hidden">

    <div id="app-wrapper">
        <div class="h-screen">
            <aside id="sidebar" class="bg-white w-64 fixed top-0 left-0 h-full shadow-lg z-20 transform md:transform-none -translate-x-full">
                <div class="sidebar-header flex items-center justify-between p-4 border-b border-gray-200">
                    <div id="logo-container" class="flex items-center">
                        <img src="{{ asset('img/airnav.ico') }}" class="w-11 h-11 mr-2" alt="Logo AirNav" onerror="this.onerror=null;this.src='https://placehold.co/62x62/FFFFFF/255A9B?text=A';">
                        <h1 id="logo-text" class="text-xl font-bold text-indigo-600">ATLAS</h1>
                    </div>
                    <button id="sidebar-toggle" class="p-2 rounded-md hover:bg-gray-200 focus:outline-none" aria-label="Toggle navigation menu">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <nav id="sidebar-menu" class="mt-6">
                    <a href="{{ route('dashboard') }}" class="nav-link flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="menu-text ml-3">Dashboard</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="nav-link flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 {{ request()->routeIs('profile.edit') ? 'menu-active' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="menu-text ml-3">Data Personal</span>
                    </a>

                    <a href="#" class="nav-link flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 {{ request()->routeIs('cnsd.harian') ? 'menu-active' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="menu-text ml-3">Harian CNSD</span>
                    </a>
                    <a href="#" class="nav-link flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 {{ request()->routeIs('tfp.harian') ? 'menu-active' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="menu-text ml-3">Harian TFP</span>
                    </a>
                    <a href="{{ route('wo.cnsd.index') }}" class="nav-link flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 {{ request()->routeIs('workorder.cnsd') ? 'menu-active' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="menu-text ml-3">Work Orders CNSD</span>
                    </a>
                    <a href="{{ route('wo.tfp.index') }}" class="nav-link flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 {{ request()->routeIs('workorder.tfp') ? 'menu-active' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path>
                        </svg>
                        <span class="menu-text ml-3">Work Orders TFP</span>
                    </a>
                    <a href="#" class="nav-link flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 {{ request()->routeIs('Meter Reading') ? 'menu-active' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                        </svg>
                        <span class="menu-text ml-3">Meter Reading</span>
                    </a>
                </nav>
                <div class="absolute bottom-0 w-full p-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            class="flex items-center text-gray-600 hover:text-indigo-600"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span id="logout-text" class="menu-text ml-3">Logout</span>
                        </a>
                    </form>
                </div>
            </aside>

            <main id="main-content" class="md:ml-64 h-full overflow-y-auto">
                <header class="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-10">
                    <div class="hidden md:block">
                        <h2 id="greeting" class="text-xl font-semibold text-gray-700">
                            Selamat Datang, {{ Auth::user()->fullname ?? 'Pengguna' }}!
                        </h2>
                    </div>
                    <button id="sidebar-open-mobile" class="p-2 rounded-md text-gray-600 hover:bg-gray-100 md:hidden" aria-label="Open navigation menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="flex items-center space-x-4 ml-auto">
                        <div class="relative"> ... </div>
                        <div class="relative">
                            <button id="profile-button" class="block h-10 w-10 rounded-full overflow-hidden border-2 border-gray-300 focus:outline-none focus:border-indigo-600">
                                <img id="avatar-img" class="h-full w-full object-cover" src="https://placehold.co/100x100/E2E8F0/4A5568?text=U" alt="Your avatar" onerror="this.onerror=null;this.src='https://placehold.co/100x100/E2E8F0/4A5568?text=U';">
                            </button>
                            <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-20">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profil</a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        Logout
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                @yield('content')

            </main>
        </div>
    </div>

    <script src="{{ asset('js/renderer_index.js') }}"></script>
</body>

</html>
