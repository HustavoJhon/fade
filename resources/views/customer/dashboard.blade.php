@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-heading font-bold text-zinc-900 dark:text-white">¡Bienvenido, {{ auth()->user()->name }}!</h1>
                <p class="text-sm text-zinc-500 mt-1">Gestiona tus citas y perfil desde aquí.</p>
            </div>
            <a href="{{ route('booking') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 text-sm font-medium rounded-lg hover:bg-zinc-800 dark:hover:bg-zinc-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Nueva cita
            </a>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
            <a href="{{ route('booking') }}" class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 flex items-center gap-4 hover:border-primary/30 dark:hover:border-primary/50 transition-all group">
                <div class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-primary dark:text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-zinc-900 dark:text-white">Reservar Cita</h3>
                    <p class="text-sm text-zinc-500">Agenda tu próximo servicio</p>
                </div>
            </a>
            <a href="{{ route('customer.appointments') }}" class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 flex items-center gap-4 hover:border-blue-200 dark:hover:border-blue-800 transition-all group">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-zinc-900 dark:text-white">Mis Citas</h3>
                    <p class="text-sm text-zinc-500">Ver historial de citas</p>
                </div>
            </a>
            <a href="{{ route('customer.profile') }}" class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 flex items-center gap-4 hover:border-purple-200 dark:hover:border-purple-800 transition-all group">
                <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-zinc-900 dark:text-white">Mi Perfil</h3>
                    <p class="text-sm text-zinc-500">Editar información personal</p>
                </div>
            </a>
        </div>

        {{-- Upcoming Appointment --}}
        <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 mb-8">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200 dark:border-white/5">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Próximas Citas</h2>
                <a href="{{ route('customer.appointments') }}" class="text-xs text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">Ver todas</a>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-white/5">
                @forelse($upcomingAppointments as $appt)
                <div class="flex items-center justify-between px-6 py-4 hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-zinc-100 dark:bg-white/5 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-zinc-900 dark:text-white">{{ $appt->service?->name }}</h4>
                            <p class="text-xs text-zinc-500">{{ $appt->barber?->user?->name }} • {{ $appt->start_time?->format('d/m/Y') }} a las {{ $appt->start_time?->format('h:i A') }}</p>
                        </div>
                    </div>
                    <span class="badge-{{ $appt->status }} text-xs">{{ ucfirst($appt->status) }}</span>
                </div>
                @empty
                <div class="px-6 py-12 text-center">
                    <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <p class="text-sm text-zinc-500">No tienes próximas citas.</p>
                    <a href="{{ route('booking') }}" class="inline-flex items-center gap-1 text-xs text-primary font-medium mt-2 hover:text-primary-dark">Reservar una cita →</a>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Recent History --}}
        <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200 dark:border-white/5">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Historial Reciente</h2>
                <a href="{{ route('customer.history') }}" class="text-xs text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">Ver historial completo</a>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-white/5">
                @forelse($recentAppointments as $appt)
                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                    <div>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $appt->service?->name }}</p>
                        <p class="text-xs text-zinc-500">{{ $appt->start_time?->format('d/m/Y') }} - {{ $appt->barber?->user?->name }}</p>
                    </div>
                    <span class="badge-{{ $appt->status }} text-xs">{{ ucfirst($appt->status) }}</span>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-sm text-zinc-500">Aún no tienes historial de citas.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
