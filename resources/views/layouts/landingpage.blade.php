<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <html data-theme="kesbangpol">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard Kesbangpol Sulteng' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="bg-base-200 font-sans antialiased">

    <!-- Navigation -->
    <div class="navbar bg-base-100 sticky top-0 z-9999 transition-all duration-300">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('dashboard.index') }}"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
                    <li><a href="{{ route('peta-sebaran.index') }}"><i class="fas fa-map-marked-alt"></i> Peta Sebaran</a></li>
                    <li><a href="{{ route('lapor-kawan.create') }}"><i class="fas fa-bullhorn"></i> Lapor Kawan</a></li>

                    @auth
                        <li><a href="{{ route('filament.admin.pages.dashboard') }}" class="{{ request()->routeIs('lapor-kawan.*') ? 'active' : '' }}">
                            <i class="fa fa-user" aria-hidden="true"></i> Admin
                        </a></li>
                    @endauth
                </ul>
            </div>
            <a href="{{ route('dashboard.index') }}" class="btn btn-ghost text-xl">
                <i class="fas fa-university"></i>
                Kesbangpol Sulteng
            </a>
        </div>

        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="{{ route('dashboard.index') }}" class="{{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Dashboard
                </a></li>
                <li><a href="{{ route('peta-sebaran.index') }}" class="{{ request()->routeIs('peta-sebaran.*') ? 'active' : '' }}">
                    <i class="fas fa-map-marked-alt"></i> Peta Sebaran
                </a></li>
                <li><a href="{{ route('lapor-kawan.create') }}" class="{{ request()->routeIs('lapor-kawan.*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> Lapor Kawan
                </a></li>
                @auth
                    <li><a href="{{ route('filament.admin.pages.dashboard') }}" class="{{ request()->routeIs('lapor-kawan.*') ? 'active' : '' }}">
                        <i class="fa fa-user" aria-hidden="true"></i> Admin
                    </a></li>
                @endauth
            </ul>
        </div>

        <div class="navbar-end">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <div class="indicator">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="badge badge-xs badge-primary indicator-item">
                            @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                                {{ auth()->user()->unreadNotifications->count() }}
                            @endif
                        </span>
                    </div>
                </div>
                <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow">
                    <div class="card-body">
                        <span class="font-bold text-lg">Notifikasi</span>
                        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                            <ul class="space-y-2">
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                    <li class="text-sm">
                                        <a href="{{ route('notifications.show', $notification->id) }}" class="text-info hover:text-blue-600">
                                            {{ $notification->data['message'] ?? 'Ada notifikasi baru!' }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-info">Tidak ada notifikasi baru</span>
                        @endif
                    </div>
                </div>
            </div>

            @guest
                <!-- Tampilkan link login atau informasi lain jika pengguna tidak terautentikasi -->
                <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
            @endguest

            @auth
                <!-- Tampilkan profil atau menu logout jika pengguna terautentikasi -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" class="btn btn-ghost btn-circle">
                        <i class="fas fa-user-circle text-lg"></i>
                    </div>
                    <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="#">Profil</a></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    </ul>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @endauth
        </div>

    </div>

    <!-- Header -->
    @if(isset($showHeader) && $showHeader)
    <div class="p-6 text-center bg-base-100 shadow-md">
        <h1 class="text-3xl font-bold">
            <i class="fas fa-university"></i>
            {{ $headerTitle ?? 'Dashboard Kesbangpol Sulteng' }}
        </h1>
        <p class="text-gray-500">{{ $headerSubtitle ?? 'Sistem Monitoring Konflik Sosial & Politik' }}</p>
    </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto p-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer footer-center p-10 bg-base-100 text-base-content rounded mt-10">
        <nav class="grid grid-flow-col gap-4">
            <a href="{{ route('dashboard.index') }}" class="link link-hover">Dashboard</a>
            <a href="{{ route('peta-sebaran.index') }}" class="link link-hover">Peta Sebaran</a>
            <a href="{{ route('lapor-kawan.create') }}" class="link link-hover">Lapor Kawan</a>
        </nav>
        <nav>
            <div class="grid grid-flow-col gap-4">
                <a><i class="fab fa-twitter text-2xl"></i></a>
                <a><i class="fab fa-youtube text-2xl"></i></a>
                <a><i class="fab fa-facebook text-2xl"></i></a>
            </div>
        </nav>
        <aside>
            <p>© {{ date('Y') }} - Kesbangpol Sulawesi Tengah. All rights reserved.</p>
        </aside>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-md', 'bg-base-100/95', 'backdrop-blur');
            } else {
                navbar.classList.remove('shadow-md', 'bg-base-100/95', 'backdrop-blur');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
