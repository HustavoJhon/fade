@extends('layouts.public')

@section('title', 'Servicios')

@section('content')
    <section class="relative pt-32 pb-24 bg-secondary hero-overlay" style="background-image: url('{{ asset('images/services-hero.jpg') }}');">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-heading font-bold text-cream">Nuestros <span class="gold-text">Servicios</span></h1>
            <p class="mt-4 text-lg text-cream/60 max-w-2xl mx-auto">Desde cortes clásicos hasta estilos modernos, ofrecemos una gama completa de servicios de barbería premium.</p>
        </div>
    </section>

    <section class="py-16 bg-cream dark:bg-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div x-data="{ category: 'todos' }">
                <div class="flex flex-wrap gap-3 mb-12 justify-center">
                    <button @click="category = 'todos'" :class="category === 'todos' ? 'bg-primary text-white' : 'bg-white dark:bg-dark-card text-secondary dark:text-cream hover:bg-primary/10'" class="px-6 py-2.5 rounded-full font-medium transition-all shadow-sm">Todos</button>
                    <button @click="category = 'cortes'" :class="category === 'cortes' ? 'bg-primary text-white' : 'bg-white dark:bg-dark-card text-secondary dark:text-cream hover:bg-primary/10'" class="px-6 py-2.5 rounded-full font-medium transition-all shadow-sm">Cortes</button>
                    <button @click="category = 'barba'" :class="category === 'barba' ? 'bg-primary text-white' : 'bg-white dark:bg-dark-card text-secondary dark:text-cream hover:bg-primary/10'" class="px-6 py-2.5 rounded-full font-medium transition-all shadow-sm">Barba</button>
                    <button @click="category = 'combo'" :class="category === 'combo' ? 'bg-primary text-white' : 'bg-white dark:bg-dark-card text-secondary dark:text-cream hover:bg-primary/10'" class="px-6 py-2.5 rounded-full font-medium transition-all shadow-sm">Combos</button>
                    <button @click="category = 'tratamientos'" :class="category === 'tratamientos' ? 'bg-primary text-white' : 'bg-white dark:bg-dark-card text-secondary dark:text-cream hover:bg-primary/10'" class="px-6 py-2.5 rounded-full font-medium transition-all shadow-sm">Tratamientos</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <template x-for="service in [
                        { name: 'Corte Clásico', category: 'cortes', desc: 'Corte tradicional con tijera y máquina, incluye lavado y styling.', price: 25, duration: '45 min', popular: true },
                        { name: 'Corte Moderno', category: 'cortes', desc: 'Corte degradado (fade) personalizado con técnicas modernas.', price: 35, duration: '50 min', popular: false },
                        { name: 'Corte Infantil', category: 'cortes', desc: 'Corte para niños, paciente y divertido.', price: 20, duration: '30 min', popular: false },
                        { name: 'Afeitado Clásico', category: 'barba', desc: 'Afeitado con navaja, toalla caliente y productos premium.', price: 30, duration: '40 min', popular: false },
                        { name: 'Arreglo de Barba', category: 'barba', desc: 'Perfilado y arreglo de barba con tijera y máquina.', price: 18, duration: '25 min', popular: true },
                        { name: 'Barba Completa', category: 'barba', desc: 'Lavado, hidratación, perfilado y styling de barba.', price: 25, duration: '35 min', popular: false },
                        { name: 'Corte + Barba', category: 'combo', desc: 'Corte personalizado + arreglo de barba completo.', price: 45, duration: '75 min', popular: true },
                        { name: 'Paquete Premium', category: 'combo', desc: 'Corte + barba + afeitado + mascarilla facial.', price: 65, duration: '90 min', popular: false },
                        { name: 'Limpieza Facial', category: 'tratamientos', desc: 'Limpieza profunda con productos específicos para hombre.', price: 35, duration: '40 min', popular: false },
                        { name: 'Mascarilla Capilar', category: 'tratamientos', desc: 'Tratamiento hidratante y reparador para el cabello.', price: 25, duration: '30 min', popular: false },
                    ]" :key="service.name">
                        <div x-show="category === 'todos' || category === service.category" x-transition:enter="transition-all duration-300" class="card group hover:-translate-y-2 relative">
                            <template x-if="service.popular">
                                <span class="absolute -top-3 right-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full">Popular</span>
                            </template>
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-heading font-bold" x-text="service.name"></h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 capitalize" x-text="service.category"></p>
                                </div>
                                <span class="text-sm text-gray-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span x-text="service.duration"></span>
                                </span>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed" x-text="service.desc"></p>
                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-2xl font-heading font-bold text-primary" x-text="'$' + service.price"></span>
                                <a href="{{ route('booking') }}" class="btn-primary text-sm !py-2 !px-5">Reservar</a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-secondary dark:bg-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-cream">¿Listo para un <span class="gold-text">cambio</span>?</h2>
            <p class="text-cream/60 mt-4 max-w-xl mx-auto">Reserva tu cita ahora y descubre la experiencia FADE.</p>
            <a href="{{ route('booking') }}" class="btn-primary inline-block mt-8 text-lg">Reservar Cita</a>
        </div>
    </section>
@endsection
