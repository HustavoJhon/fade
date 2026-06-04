@extends('layouts.customer')

@section('title', 'Mis Citas')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-heading font-bold text-zinc-900 dark:text-white">Mis Citas</h1>
                <p class="text-sm text-zinc-500 mt-1">Administra tus citas programadas.</p>
            </div>
            <a href="{{ route('booking') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 text-sm font-medium rounded-lg hover:bg-zinc-800 dark:hover:bg-zinc-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Nueva cita
            </a>
        </div>

        <div x-data="{ tab: 'upcoming' }">
            <div class="flex gap-4 mb-8 border-b border-zinc-200 dark:border-white/5">
                <button @click="tab = 'upcoming'" :class="tab === 'upcoming' ? 'text-primary border-primary' : 'text-zinc-400 border-transparent hover:text-zinc-600 dark:hover:text-zinc-300'" class="pb-4 border-b-2 font-medium text-sm transition-colors">Próximas</button>
                <button @click="tab = 'history'" :class="tab === 'history' ? 'text-primary border-primary' : 'text-zinc-400 border-transparent hover:text-zinc-600 dark:hover:text-zinc-300'" class="pb-4 border-b-2 font-medium text-sm transition-colors">Historial</button>
            </div>

            <div x-show="tab === 'upcoming'" class="space-y-4">
                @forelse($upcomingAppointments as $appt)
                <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-zinc-100 dark:bg-white/5 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-zinc-900 dark:text-white">{{ $appt->service?->name }}</h3>
                            <p class="text-sm text-zinc-500 mt-1">{{ $appt->barber?->user?->name }} • {{ $appt->start_time?->format('d/m/Y') }} a las {{ $appt->start_time?->format('h:i A') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="badge-{{ $appt->status }} text-xs">{{ ucfirst($appt->status) }}</span>
                        @if(in_array($appt->status, ['pending', 'confirmed']))
                        <form method="POST" action="{{ route('customer.appointments.cancel', $appt) }}" onsubmit="return confirm('¿Cancelar esta cita?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-medium border border-red-200 dark:border-red-900/50 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">Cancelar</button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 py-16 text-center">
                    <div class="w-14 h-14 rounded-full bg-zinc-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <p class="text-sm text-zinc-500">No tienes citas próximas.</p>
                    <a href="{{ route('booking') }}" class="inline-flex items-center gap-1 text-xs text-primary font-medium mt-2 hover:text-primary-dark">Reservar una cita →</a>
                </div>
                @endforelse
            </div>

            <div x-show="tab === 'history'" class="space-y-4">
                @forelse($historyAppointments as $appt)
                <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 opacity-70 hover:opacity-100 transition-opacity">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-zinc-100 dark:bg-white/5 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-zinc-900 dark:text-white">{{ $appt->service?->name }}</h3>
                            <p class="text-sm text-zinc-500 mt-1">{{ $appt->barber?->user?->name }} • {{ $appt->start_time?->format('d/m/Y') }} a las {{ $appt->start_time?->format('h:i A') }}</p>
                            <p class="text-xs text-zinc-400 mt-1">${{ number_format($appt->total_price, 0) }}</p>
                        </div>
                    </div>
                    <span class="badge-{{ $appt->status }} text-xs">{{ ucfirst($appt->status) }}</span>
                </div>
                @empty
                <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 py-16 text-center">
                    <div class="w-14 h-14 rounded-full bg-zinc-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-sm text-zinc-500">No hay historial de citas.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection