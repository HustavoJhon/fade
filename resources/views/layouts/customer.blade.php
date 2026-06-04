<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>@yield('title', 'Mi Cuenta') - FADE</title>
</head>
<body class="bg-zinc-50 dark:bg-secondary antialiased">
    <div class="min-h-screen flex flex-col">
        {{-- Header --}}
        <header class="bg-white dark:bg-secondary border-b border-zinc-200 dark:border-white/5 sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg gold-gradient flex items-center justify-center text-white font-heading font-bold text-sm">F</div>
                        <span class="text-base font-heading font-bold gold-text hidden sm:block">FADE</span>
                    </a>
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="{{ route('customer.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('customer.dashboard') ? 'bg-primary/10 text-primary' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-white/5' }}">Dashboard</a>
                        <a href="{{ route('customer.appointments') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('customer.appointments') ? 'bg-primary/10 text-primary' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-white/5' }}">Mis Citas</a>
                        <a href="{{ route('customer.history') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('customer.history') ? 'bg-primary/10 text-primary' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-white/5' }}">Historial</a>
                        <a href="{{ route('customer.profile') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('customer.profile') ? 'bg-primary/10 text-primary' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-white/5' }}">Perfil</a>
                    </nav>
                    <div class="flex items-center gap-2">
                        <button data-toggle-dark class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-white/5">
                            <svg x-cloak x-show="!document.documentElement.classList.contains('dark')" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
                            <svg x-cloak x-show="document.documentElement.classList.contains('dark')" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                        </button>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-white/5 transition-colors">
                                <div class="w-7 h-7 rounded-lg gold-gradient flex items-center justify-center text-white text-xs font-semibold">
                                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                                </div>
                                <span class="hidden sm:block text-sm font-medium max-w-[100px] truncate">{{ auth()->user()->name ?? 'Cliente' }}</span>
                                <svg class="w-3.5 h-3.5 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-52 bg-white dark:bg-secondary rounded-xl shadow-xl border border-zinc-200 dark:border-white/10 overflow-hidden z-50">
                                <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">Mi Perfil</a>
                                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">Volver al sitio</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">Cerrar sesión</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Mobile nav --}}
                <div class="flex md:hidden gap-1 pb-3 overflow-x-auto">
                    <a href="{{ route('customer.dashboard') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-colors {{ request()->routeIs('customer.dashboard') ? 'bg-primary/10 text-primary' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">Dashboard</a>
                    <a href="{{ route('customer.appointments') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-colors {{ request()->routeIs('customer.appointments') ? 'bg-primary/10 text-primary' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">Mis Citas</a>
                    <a href="{{ route('customer.history') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-colors {{ request()->routeIs('customer.history') ? 'bg-primary/10 text-primary' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">Historial</a>
                    <a href="{{ route('customer.profile') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-colors {{ request()->routeIs('customer.profile') ? 'bg-primary/10 text-primary' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">Perfil</a>
                    <a href="{{ route('booking') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap text-primary bg-primary/10 dark:bg-primary/20">Reservar</a>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1">
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        {{-- Simple footer --}}
        <footer class="border-t border-zinc-200 dark:border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between text-xs text-zinc-400">
                    <span>&copy; {{ date('Y') }} FADE Barbería</span>
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Ir al sitio</a>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>