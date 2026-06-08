@extends('layouts.public')

@section('title', 'Galería')

@section('content')
    <section class="relative pt-32 pb-24 bg-secondary hero-overlay" style="background-image: url('{{ asset('images/gallery-hero.jpg') }}');">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-heading font-bold text-cream">Nuestra <span class="gold-text">Galería</span></h1>
            <p class="mt-4 text-lg text-cream/60 max-w-2xl mx-auto">El arte de nuestros barberos plasmado en cada corte. Descubre nuestro trabajo.</p>
        </div>
    </section>

    <section class="py-24 bg-cream dark:bg-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div x-data="{ 
                barber: 'todos', 
                lightbox: null,
                items: [
                    { src: '{{ asset('images/gallery-1.jpg') }}', barber: 'alejandro', caption: 'Fade degradado', category: 'cortes' },
                    { src: '{{ asset('images/gallery-2.jpg') }}', barber: 'carlos', caption: 'Barba perfilada', category: 'barba' },
                    { src: '{{ asset('images/gallery-3.jpg') }}', barber: 'miguel', caption: 'Corte moderno', category: 'cortes' },
                    { src: '{{ asset('images/gallery-4.jpg') }}', barber: 'alejandro', caption: 'Diseño fade', category: 'cortes' },
                    { src: '{{ asset('images/gallery-5.jpg') }}', barber: 'carlos', caption: 'Afeitado clásico', category: 'barba' },
                    { src: '{{ asset('images/gallery-6.jpg') }}', barber: 'miguel', caption: 'Degradado militar', category: 'cortes' },
                    { src: '{{ asset('images/gallery-7.jpg') }}', barber: 'alejandro', caption: 'Corte + barba', category: 'combo' },
                    { src: '{{ asset('images/gallery-8.jpg') }}', barber: 'carlos', caption: 'Estilo texturizado', category: 'cortes' },
                    { src: '{{ asset('images/gallery-9.jpg') }}', barber: 'miguel', caption: 'Fade medio', category: 'cortes' },
                    { src: '{{ asset('images/gallery-10.jpg') }}', barber: 'alejandro', caption: 'Barba completa', category: 'barba' },
                    { src: '{{ asset('images/gallery-11.jpg') }}', barber: 'carlos', caption: 'Corte degradado alto', category: 'cortes' },
                    { src: '{{ asset('images/gallery-12.jpg') }}', barber: 'miguel', caption: 'Estilo pompadour', category: 'cortes' },
                ]
            }">
                <div class="flex flex-wrap gap-3 mb-12 justify-center">
                    <button @click="barber = 'todos'" :class="barber === 'todos' ? 'bg-primary text-white' : 'bg-white dark:bg-dark-card text-secondary dark:text-cream hover:bg-primary/10'" class="px-6 py-2.5 rounded-full font-medium transition-all shadow-sm">Todos</button>
                    <button @click="barber = 'alejandro'" :class="barber === 'alejandro' ? 'bg-primary text-white' : 'bg-white dark:bg-dark-card text-secondary dark:text-cream hover:bg-primary/10'" class="px-6 py-2.5 rounded-full font-medium transition-all shadow-sm">Alejandro</button>
                    <button @click="barber = 'carlos'" :class="barber === 'carlos' ? 'bg-primary text-white' : 'bg-white dark:bg-dark-card text-secondary dark:text-cream hover:bg-primary/10'" class="px-6 py-2.5 rounded-full font-medium transition-all shadow-sm">Carlos</button>
                    <button @click="barber = 'miguel'" :class="barber === 'miguel' ? 'bg-primary text-white' : 'bg-white dark:bg-dark-card text-secondary dark:text-cream hover:bg-primary/10'" class="px-6 py-2.5 rounded-full font-medium transition-all shadow-sm">Miguel</button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    <template x-for="(item, index) in items" :key="index">
                        <div x-show="barber === 'todos' || barber === item.barber" x-transition:enter="transition-all duration-300" class="group relative overflow-hidden rounded-xl aspect-square bg-primary/5 cursor-pointer" @click="lightbox = index">
                            <img x-bind:src="item.src" alt="" class="w-full h-full object-cover absolute inset-0 group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-secondary/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-5">
                                <p class="text-cream font-semibold text-sm" x-text="item.caption"></p>
                                <p class="text-primary text-xs mt-1" x-text="'Por ' + item.barber.charAt(0).toUpperCase() + item.barber.slice(1)"></p>
                            </div>
                        </div>
                    </template>
                </div>

                <div x-show="lightbox !== null" x-cloak class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4" @click.away="lightbox = null" @keydown.escape="lightbox = null">
                    <button @click="lightbox = null" class="absolute top-6 right-6 text-white/60 hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <button @click="lightbox = Math.max(0, lightbox - 1)" x-show="lightbox > 0" class="absolute left-6 text-white/60 hover:text-white transition-colors">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <div class="max-w-3xl w-full bg-dark-card rounded-2xl overflow-hidden shadow-2xl">
                        <div class="aspect-square relative bg-dark-card">
                            <img x-bind:src="lightbox !== null ? items[lightbox].src : ''" alt="" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 text-center">
                            <p class="text-cream font-semibold" x-text="lightbox !== null ? items[lightbox].caption : ''"></p>
                        </div>
                    </div>
                    <button @click="lightbox = Math.min(11, lightbox + 1)" x-show="lightbox < 11" class="absolute right-6 text-white/60 hover:text-white transition-colors">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
