@extends('layouts.public')

@section('title', 'Horarios')

@section('content')
    <section class="relative pt-32 pb-24 bg-secondary hero-overlay" style="background-image: url('{{ asset('images/hours-hero.jpg') }}');">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-heading font-bold text-cream">Horarios de <span class="gold-text">Atención</span></h1>
            <p class="mt-4 text-lg text-cream/60 max-w-2xl mx-auto">Visítanos en nuestros horarios regulares. Estamos listos para atenderte.</p>
        </div>
    </section>

    <section class="py-24 bg-cream dark:bg-secondary">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-8 md:p-12">
                <div class="text-center mb-12">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-heading font-bold mt-4">Horario <span class="gold-text">Regular</span></h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Estos son nuestros horarios de atención regulares.</p>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-5 rounded-xl bg-cream dark:bg-secondary border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors">
                                <span class="text-primary font-bold text-sm group-hover:text-white transition-colors">L</span>
                            </div>
                            <span class="font-medium">Lunes</span>
                        </div>
                        <span class="text-primary font-semibold">9:00 AM - 7:00 PM</span>
                    </div>
                    <div class="flex items-center justify-between p-5 rounded-xl bg-cream dark:bg-secondary border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors">
                                <span class="text-primary font-bold text-sm group-hover:text-white transition-colors">M</span>
                            </div>
                            <span class="font-medium">Martes</span>
                        </div>
                        <span class="text-primary font-semibold">9:00 AM - 7:00 PM</span>
                    </div>
                    <div class="flex items-center justify-between p-5 rounded-xl bg-cream dark:bg-secondary border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors">
                                <span class="text-primary font-bold text-sm group-hover:text-white transition-colors">M</span>
                            </div>
                            <span class="font-medium">Miércoles</span>
                        </div>
                        <span class="text-primary font-semibold">9:00 AM - 7:00 PM</span>
                    </div>
                    <div class="flex items-center justify-between p-5 rounded-xl bg-cream dark:bg-secondary border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors">
                                <span class="text-primary font-bold text-sm group-hover:text-white transition-colors">J</span>
                            </div>
                            <span class="font-medium">Jueves</span>
                        </div>
                        <span class="text-primary font-semibold">9:00 AM - 7:00 PM</span>
                    </div>
                    <div class="flex items-center justify-between p-5 rounded-xl bg-cream dark:bg-secondary border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors">
                                <span class="text-primary font-bold text-sm group-hover:text-white transition-colors">V</span>
                            </div>
                            <span class="font-medium">Viernes</span>
                        </div>
                        <span class="text-primary font-semibold">9:00 AM - 7:00 PM</span>
                    </div>
                    <div class="flex items-center justify-between p-5 rounded-xl bg-cream dark:bg-secondary border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors">
                                <span class="text-primary font-bold text-sm group-hover:text-white transition-colors">S</span>
                            </div>
                            <span class="font-medium">Sábado</span>
                        </div>
                        <span class="text-primary font-semibold">9:00 AM - 6:00 PM</span>
                    </div>
                    <div class="flex items-center justify-between p-5 rounded-xl bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                <span class="text-red-500 font-bold text-sm">D</span>
                            </div>
                            <span class="font-medium">Domingo</span>
                        </div>
                        <span class="text-red-500 font-semibold">Cerrado</span>
                    </div>
                </div>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        <h3 class="text-lg font-heading font-bold">Días Festivos</h3>
                    </div>
                    <div class="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                        <p>1 de Enero - Año Nuevo <span class="text-red-500">(Cerrado)</span></p>
                        <p>25 de Diciembre - Navidad <span class="text-red-500">(Cerrado)</span></p>
                        <p>1 de Mayo - Día del Trabajo <span class="text-yellow-500">(Horario reducido)</span></p>
                    </div>
                </div>
                <div class="card">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h3 class="text-lg font-heading font-bold">Notas importantes</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400 list-disc list-inside">
                        <li>Último corte 30 minutos antes del cierre</li>
                        <li>Se requiere cita previa para sábados</li>
                        <li>Consultar disponibilidad en días festivos</li>
                    </ul>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('booking') }}" class="btn-primary text-lg inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Reservar Cita
                </a>
            </div>
        </div>
    </section>
@endsection
