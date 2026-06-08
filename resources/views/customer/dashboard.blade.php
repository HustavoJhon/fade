@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- Welcome Banner --}}
        <div class="relative overflow-hidden rounded-2xl gold-gradient p-6 md:p-8">
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/70 text-sm font-medium tracking-wide uppercase">Dashboard</p>
                        <h1 class="text-2xl md:text-3xl font-heading font-bold text-white mt-1">¡Bienvenido, {{ auth()->user()->name }}!</h1>
                        <p class="text-white/80 text-sm mt-1 max-w-lg">Gestiona tus citas, revisa tu historial y mantén tu perfil actualizado.</p>
                    </div>
                    <a href="{{ route('booking') }}" class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-xl hover:bg-white/30 transition-all border border-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Nueva cita
                    </a>
                </div>
            </div>
            <div class="absolute -top-6 -right-6 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Completadas</span>
                </div>
                <p class="text-2xl font-heading font-bold text-zinc-900 dark:text-white">{{ $completedCount ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Próximas</span>
                </div>
                <p class="text-2xl font-heading font-bold text-zinc-900 dark:text-white">{{ $upcomingAppointments->count() }}</p>
            </div>
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                    </div>
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Total</span>
                </div>
                <p class="text-2xl font-heading font-bold text-zinc-900 dark:text-white">{{ $totalAppointments ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Miembro desde</span>
                </div>
                <p class="text-lg font-heading font-bold text-zinc-900 dark:text-white">{{ auth()->user()->created_at?->format('M Y') }}</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div>
            <h2 class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-4">Acceso rápido</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('booking') }}" class="group relative bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 flex items-center gap-4 hover:border-primary/40 dark:hover:border-primary/60 hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-zinc-900 dark:text-white group-hover:text-primary transition-colors">Reservar Cita</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Agenda tu próximo servicio</p>
                    </div>
                    <svg class="w-5 h-5 text-zinc-300 dark:text-zinc-600 group-hover:text-primary ml-auto transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
                <a href="{{ route('customer.appointments') }}" class="group relative bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 flex items-center gap-4 hover:border-primary/40 dark:hover:border-primary/60 hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-zinc-900 dark:text-white group-hover:text-primary transition-colors">Mis Citas</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Ver y gestionar citas</p>
                    </div>
                    <svg class="w-5 h-5 text-zinc-300 dark:text-zinc-600 group-hover:text-primary ml-auto transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
                <a href="{{ route('customer.profile') }}" class="group relative bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 flex items-center gap-4 hover:border-primary/40 dark:hover:border-primary/60 hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-zinc-900 dark:text-white group-hover:text-primary transition-colors">Mi Perfil</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Editar información personal</p>
                    </div>
                    <svg class="w-5 h-5 text-zinc-300 dark:text-zinc-600 group-hover:text-primary ml-auto transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            </div>
        </div>

        {{-- Upcoming Appointment --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Próximas Citas</h2>
                <a href="{{ route('customer.appointments') }}" class="text-xs text-primary font-medium hover:underline">Ver todas</a>
            </div>
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 overflow-hidden">
                @forelse($upcomingAppointments as $appt)
                <div class="group relative flex items-center justify-between px-6 py-4 hover:pl-8 transition-all duration-200 {{ !$loop->first ? 'border-t border-zinc-100 dark:border-white/5' : '' }}">
                    <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform duration-200 origin-top"></div>
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-xl bg-primary/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $appt->service?->name }}</h4>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-xs text-zinc-500">{{ $appt->barber?->user?->name }}</span>
                                <span class="text-zinc-300 dark:text-zinc-600">•</span>
                                <span class="text-xs text-zinc-500">{{ $appt->start_time?->format('d/m/Y') }}</span>
                                <span class="text-zinc-300 dark:text-zinc-600">•</span>
                                <span class="text-xs font-medium text-primary">{{ $appt->start_time?->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                    <span class="badge-{{ $appt->status }} text-xs">{{ ucfirst($appt->status) }}</span>
                </div>
                @empty
                <div class="px-6 py-12 text-center">
                    <div class="w-14 h-14 rounded-full bg-zinc-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <p class="text-sm font-medium text-zinc-900 dark:text-white">Sin citas próximas</p>
                    <p class="text-xs text-zinc-500 mt-1">Agenda tu primer corte y vive la experiencia FADE.</p>
                    <a href="{{ route('booking') }}" class="inline-flex items-center gap-1 text-sm text-primary font-semibold mt-4 hover:underline">Reservar ahora →</a>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Recent History --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Historial Reciente</h2>
                <a href="{{ route('customer.history') }}" class="text-xs text-primary font-medium hover:underline">Ver historial completo</a>
            </div>
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 overflow-hidden">
                @forelse($recentAppointments as $appt)
                <div class="group relative flex items-center justify-between px-6 py-3.5 hover:pl-8 transition-all duration-200 {{ !$loop->first ? 'border-t border-zinc-100 dark:border-white/5' : '' }}">
                    <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform duration-200 origin-top"></div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-white/5 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $appt->service?->name }}</p>
                            <p class="text-xs text-zinc-500">{{ $appt->start_time?->format('d/m/Y') }} · {{ $appt->barber?->user?->name }}</p>
                        </div>
                    </div>
                    <span class="badge-{{ $appt->status }} text-xs">{{ ucfirst($appt->status) }}</span>
                </div>
                @empty
                <div class="px-6 py-10 text-center">
                    <p class="text-sm text-zinc-500">Aún no tienes historial de citas.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
