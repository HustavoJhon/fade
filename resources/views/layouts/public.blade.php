<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'FADE - Barbería premium. Donde el estilo se encuentra con la tradición. Cortes modernos, barbas impecables y experiencia única.')">
    <meta name="keywords" content="barbería, barbero, corte de pelo, barba, fade, grooming, estilo">
    <meta property="og:title" content="@yield('title', config('app.name', 'FADE')) - Barbería Premium">
    <meta property="og:description" content="Donde el Estilo se Encuentra con la Tradición">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>@yield('title', config('app.name', 'FADE')) - Barbería Premium</title>
</head>
<body class="bg-cream dark:bg-secondary text-secondary dark:text-cream antialiased">
    <nav x-data="{ open: false, scrolled: false }"
         x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 50)"
         :class="scrolled ? 'bg-secondary/95 backdrop-blur-md shadow-lg' : 'bg-transparent'"
         class="fixed w-full z-40 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-2xl font-bold font-heading gold-text">FADE</span>
                </a>
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'text-primary' : 'text-cream/80 hover:text-primary' }} transition-colors font-medium">Inicio</a>
                    <a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services') ? 'text-primary' : 'text-cream/80 hover:text-primary' }} transition-colors font-medium">Servicios</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'text-primary' : 'text-cream/80 hover:text-primary' }} transition-colors font-medium">Nosotros</a>
                    <a href="{{ route('gallery') }}" class="nav-link {{ request()->routeIs('gallery') ? 'text-primary' : 'text-cream/80 hover:text-primary' }} transition-colors font-medium">Galería</a>
                    <a href="{{ route('hours') }}" class="nav-link {{ request()->routeIs('hours') ? 'text-primary' : 'text-cream/80 hover:text-primary' }} transition-colors font-medium">Horarios</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'text-primary' : 'text-cream/80 hover:text-primary' }} transition-colors font-medium">Contacto</a>
                    <button data-toggle-dark class="text-cream/80 hover:text-primary transition-colors p-2" title="Modo oscuro">
                        <svg x-cloak x-show="!document.documentElement.classList.contains('dark')" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-cloak x-show="document.documentElement.classList.contains('dark')" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>
                    <a href="{{ route('booking') }}" class="btn-primary text-sm !py-2.5 !px-6">
                        Reservar Cita
                    </a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-cream/80 hover:text-primary transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                            </a>
                        @else
                            <a href="{{ route('customer.dashboard') }}" class="text-cream/80 hover:text-primary transition-colors font-medium">Mi Cuenta</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-cream/80 hover:text-primary transition-colors font-medium">Ingresar</a>
                    @endauth
                </div>
                <div class="flex lg:hidden items-center gap-3">
                    <button data-toggle-dark class="text-cream/80 hover:text-primary transition-colors p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                    <button @click="open = !open" class="text-cream p-2">
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div x-show="open" x-cloak @click.away="open = false" class="lg:hidden bg-secondary/98 backdrop-blur-md border-t border-primary/20">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('home') ? 'text-primary bg-primary/10' : 'text-cream/80 hover:bg-primary/5' }} transition-colors font-medium">Inicio</a>
                <a href="{{ route('services') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('services') ? 'text-primary bg-primary/10' : 'text-cream/80 hover:bg-primary/5' }} transition-colors font-medium">Servicios</a>
                <a href="{{ route('about') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('about') ? 'text-primary bg-primary/10' : 'text-cream/80 hover:bg-primary/5' }} transition-colors font-medium">Nosotros</a>
                <a href="{{ route('gallery') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('gallery') ? 'text-primary bg-primary/10' : 'text-cream/80 hover:bg-primary/5' }} transition-colors font-medium">Galería</a>
                <a href="{{ route('hours') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('hours') ? 'text-primary bg-primary/10' : 'text-cream/80 hover:bg-primary/5' }} transition-colors font-medium">Horarios</a>
                <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('contact') ? 'text-primary bg-primary/10' : 'text-cream/80 hover:bg-primary/5' }} transition-colors font-medium">Contacto</a>
                <hr class="border-primary/20 my-3">
                @auth
                    <a href="{{ route('customer.dashboard') }}" class="block px-4 py-3 rounded-lg text-cream/80 hover:bg-primary/5 transition-colors font-medium">Mi Cuenta</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-3 rounded-lg text-cream/80 hover:bg-primary/5 transition-colors font-medium">Cerrar Sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-3 rounded-lg text-cream/80 hover:bg-primary/5 transition-colors font-medium">Ingresar</a>
                    <a href="{{ route('register') }}" class="block px-4 py-3 rounded-lg text-primary bg-primary/10 transition-colors font-medium">Registrarse</a>
                @endauth
                <a href="{{ route('booking') }}" class="block text-center btn-primary mt-4">Reservar Cita</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <footer class="bg-secondary text-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <span class="text-3xl font-bold font-heading gold-text">FADE</span>
                    <p class="mt-4 text-cream/60 leading-relaxed">Donde el estilo se encuentra con la tradición. Más que una barbería, una experiencia de cuidado personal premium.</p>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all" aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all" aria-label="TikTok">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-heading font-semibold mb-6 gold-text">Enlaces Rápidos</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-cream/60 hover:text-primary transition-colors">Inicio</a></li>
                        <li><a href="{{ route('services') }}" class="text-cream/60 hover:text-primary transition-colors">Servicios</a></li>
                        <li><a href="{{ route('about') }}" class="text-cream/60 hover:text-primary transition-colors">Nosotros</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-cream/60 hover:text-primary transition-colors">Galería</a></li>
                        <li><a href="{{ route('hours') }}" class="text-cream/60 hover:text-primary transition-colors">Horarios</a></li>
                        <li><a href="{{ route('contact') }}" class="text-cream/60 hover:text-primary transition-colors">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-heading font-semibold mb-6 gold-text">Horarios</h4>
                    <ul class="space-y-3 text-cream/60">
                        <li class="flex justify-between"><span>Lunes - Viernes</span><span>9:00 AM - 7:00 PM</span></li>
                        <li class="flex justify-between"><span>Sábado</span><span>9:00 AM - 6:00 PM</span></li>
                        <li class="flex justify-between"><span>Domingo</span><span class="text-primary">Cerrado</span></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-heading font-semibold mb-6 gold-text">Contacto</h4>
                    <ul class="space-y-4 text-cream/60">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Av. Principal 123, Ciudad</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>+1 (555) 123-4567</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>info@fadebarberia.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-primary/20 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-cream/40 text-sm">&copy; {{ date('Y') }} FADE Barbería. Todos los derechos reservados.</p>
                <div class="flex gap-6 text-cream/40 text-sm">
                    <a href="#" class="hover:text-primary transition-colors">Términos</a>
                    <a href="#" class="hover:text-primary transition-colors">Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/15551234567?text=Hola%2C%20quiero%20agendar%20una%20cita" target="_blank" class="whatsapp-float" aria-label="WhatsApp">
        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.294-.152-1.79-.864-2.07-.96-.28-.096-.484-.144-.688.144-.204.288-.78.96-.96 1.152-.176.192-.352.216-.648.072-.296-.144-1.252-.46-2.384-1.472-.88-.784-1.472-1.752-1.648-2.048-.176-.296-.02-.456.128-.6.136-.128.296-.336.444-.504.148-.168.2-.288.296-.48.096-.192.048-.36-.024-.504-.072-.144-.656-1.576-.896-2.152-.24-.576-.48-.48-.656-.48-.168-.008-.368-.008-.568-.008-.2 0-.52.072-.792.36-.272.288-1.04 1.016-1.04 2.48 0 1.464 1.064 2.88 1.216 3.080.152.2 2.096 3.208 5.088 4.496.712.312 1.264.496 1.696.632.72.224 1.376.192 1.896.12.58-.08 1.792-.736 2.048-1.448.256-.712.256-1.32.192-1.448-.064-.128-.24-.208-.536-.36zM12 2C6.48 2 2 6.48 2 12c0 2.168.72 4.16 1.912 5.768L2.94 21.06l3.292-1.008A9.914 9.914 0 0012 22c5.52 0 10-4.48 10-10S17.52 2 12 2z"/></svg>
    </a>

    @livewireScripts
    @stack('scripts')
</body>
</html>
