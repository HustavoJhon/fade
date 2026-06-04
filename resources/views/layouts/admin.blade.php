<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>@yield('title', 'FADE Panel') - FADE</title>
</head>
<body class="bg-[#f5f5f5] dark:bg-secondary text-zinc-800 dark:text-zinc-200 antialiased">
    <div x-data="{ sidebarOpen: true, mobileOpen: false }" class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside
            :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="hidden lg:flex flex-col bg-secondary border-r border-white/5 transition-all duration-200 fixed left-0 top-0 h-full z-40"
        >
            {{-- Logo --}}
            <div class="flex items-center h-16 px-5 border-b border-white/5" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg gold-gradient flex items-center justify-center text-white font-bold text-sm">F</div>
                    <span x-show="sidebarOpen" class="text-base font-heading font-semibold text-white">FADE</span>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" x-show="sidebarOpen" class="text-zinc-500 hover:text-zinc-300 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 20L6 12l12-8"/></svg>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white font-medium' : 'text-zinc-400 hover:text-zinc-200 hover:bg-white/5' }}" :class="sidebarOpen ? '' : 'justify-center'" title="Dashboard">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>
                <a href="{{ route('admin.calendar') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.calendar') ? 'bg-white/10 text-white font-medium' : 'text-zinc-400 hover:text-zinc-200 hover:bg-white/5' }}" :class="sidebarOpen ? '' : 'justify-center'" title="Calendario">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    <span x-show="sidebarOpen">Calendario</span>
                </a>
                <a href="{{ route('admin.appointments') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.appointments') ? 'bg-white/10 text-white font-medium' : 'text-zinc-400 hover:text-zinc-200 hover:bg-white/5' }}" :class="sidebarOpen ? '' : 'justify-center'" title="Citas">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    <span x-show="sidebarOpen">Citas</span>
                </a>
                <a href="{{ route('admin.customers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.customers*') ? 'bg-white/10 text-white font-medium' : 'text-zinc-400 hover:text-zinc-200 hover:bg-white/5' }}" :class="sidebarOpen ? '' : 'justify-center'" title="Clientes">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    <span x-show="sidebarOpen">Clientes</span>
                </a>
                <a href="{{ route('admin.barbers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.barbers') ? 'bg-white/10 text-white font-medium' : 'text-zinc-400 hover:text-zinc-200 hover:bg-white/5' }}" :class="sidebarOpen ? '' : 'justify-center'" title="Barberos">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    <span x-show="sidebarOpen">Barberos</span>
                </a>
                <a href="{{ route('admin.services') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.services') ? 'bg-white/10 text-white font-medium' : 'text-zinc-400 hover:text-zinc-200 hover:bg-white/5' }}" :class="sidebarOpen ? '' : 'justify-center'" title="Servicios">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                    <span x-show="sidebarOpen">Servicios</span>
                </a>
                <a href="{{ route('admin.finance') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.finance') ? 'bg-white/10 text-white font-medium' : 'text-zinc-400 hover:text-zinc-200 hover:bg-white/5' }}" :class="sidebarOpen ? '' : 'justify-center'" title="Finanzas">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-show="sidebarOpen">Finanzas</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.reports') ? 'bg-white/10 text-white font-medium' : 'text-zinc-400 hover:text-zinc-200 hover:bg-white/5' }}" :class="sidebarOpen ? '' : 'justify-center'" title="Reportes">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3H19.5v6"/></svg>
                    <span x-show="sidebarOpen">Reportes</span>
                </a>
                <a href="{{ route('admin.gallery') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.gallery') ? 'bg-white/10 text-white font-medium' : 'text-zinc-400 hover:text-zinc-200 hover:bg-white/5' }}" :class="sidebarOpen ? '' : 'justify-center'" title="Galería">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21zm16.5-9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span x-show="sidebarOpen">Galería</span>
                </a>
            </nav>

            {{-- Bottom actions --}}
            <div class="border-t border-white/5 p-3">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm text-zinc-400 hover:text-zinc-200 hover:bg-white/5 transition-all" :class="sidebarOpen ? '' : 'justify-center'">
                        <div class="w-7 h-7 rounded-lg gold-gradient flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span x-show="sidebarOpen" class="flex-1 text-left truncate">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <svg x-show="sidebarOpen" class="w-3.5 h-3.5 flex-shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute bottom-full left-0 right-0 mb-1 bg-[#1a1a24] rounded-lg shadow-xl border border-white/10 overflow-hidden z-50">
                        <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-400 hover:text-white hover:bg-white/5 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Configuración
                        </a>
                        <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-zinc-400 hover:text-white hover:bg-white/5 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                            Sitio web
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-400 hover:text-red-300 hover:bg-red-900/20 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Mobile sidebar --}}
        <aside x-show="mobileOpen" x-cloak class="lg:hidden fixed inset-0 z-50">
            <div @click="mobileOpen = false" class="absolute inset-0 bg-black/60"></div>
            <div class="relative w-64 h-full bg-secondary overflow-y-auto">
                <div class="flex items-center justify-between h-16 px-5 border-b border-white/5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg gold-gradient flex items-center justify-center text-white font-bold text-sm">F</div>
                        <span class="text-base font-heading font-semibold text-white">FADE</span>
                    </a>
                    <button @click="mobileOpen = false" class="text-zinc-500 hover:text-zinc-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <nav class="px-3 py-4 space-y-1">
                    @foreach([
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
                        ['route' => 'admin.calendar', 'label' => 'Calendario'],
                        ['route' => 'admin.appointments', 'label' => 'Citas'],
                        ['route' => 'admin.customers', 'label' => 'Clientes'],
                        ['route' => 'admin.barbers', 'label' => 'Barberos'],
                        ['route' => 'admin.services', 'label' => 'Servicios'],
                        ['route' => 'admin.finance', 'label' => 'Finanzas'],
                        ['route' => 'admin.reports', 'label' => 'Reportes'],
                        ['route' => 'admin.gallery', 'label' => 'Galería'],
                        ['route' => 'admin.settings', 'label' => 'Configuración'],
                    ] as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs($item['route']) ? 'bg-white/10 text-white font-medium' : 'text-zinc-400 hover:text-zinc-200 hover:bg-white/5' }}">
                        {{ $item['label'] }}
                    </a>
                    @endforeach
                </nav>
                <div class="p-3 border-t border-white/5">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm text-red-400 hover:text-red-300 hover:bg-red-900/20">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main area --}}
        <div class="flex-1 flex flex-col min-h-screen" :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'">
            {{-- Header --}}
            <header class="bg-white dark:bg-secondary border-b border-gray-200 dark:border-white/5 sticky top-0 z-30 h-16">
                <div class="flex items-center justify-between h-full px-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <button @click="mobileOpen = true" class="lg:hidden text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 p-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-white/5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                        </button>
                        <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:flex text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors p-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-white/5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                        </button>
                        <div class="h-5 w-px bg-gray-200 dark:bg-white/10 hidden sm:block"></div>
                        <h2 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 hidden sm:block">
                            @yield('page_title', 'Dashboard')
                        </h2>
                    </div>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('home') }}" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5" title="Ver sitio">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                        </a>
                        <button data-toggle-dark class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5" title="Modo oscuro">
                            <svg x-cloak x-show="!document.documentElement.classList.contains('dark')" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
                            <svg x-cloak x-show="document.documentElement.classList.contains('dark')" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                        </button>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-6 lg:p-8">
                @yield('content')
                {{ $slot ?? '' }}
            </main>

            <footer class="px-6 lg:px-8 py-4 border-t border-gray-200 dark:border-white/5">
                <div class="flex items-center justify-between text-xs text-zinc-400">
                    <span>&copy; {{ date('Y') }} FADE Barbería</span>
                    <span>v1.0.0</span>
                </div>
            </footer>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>