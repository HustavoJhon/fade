@extends('layouts.admin')

@section('title', 'Panel del Barbero')

@section('content')
    <div>
        <div class="mb-8">
            <h1 class="text-3xl font-heading font-bold">Bienvenido, {{ auth()->user()->name }}</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Aquí tienes un resumen de tu jornada.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800 text-sm">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="card">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-500">Citas Hoy</span>
                    <div class="w-9 h-9 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-heading font-bold">{{ $todayCount }}</div>
            </div>
            <div class="card">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-500">Ingresos Hoy</span>
                    <div class="w-9 h-9 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-heading font-bold text-green-500">${{ number_format($todayRevenue, 0) }}</div>
            </div>
            <div class="card">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-500">Pendientes</span>
                    <div class="w-9 h-9 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-heading font-bold text-yellow-500">{{ $pendingCount }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 card">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-heading font-bold">Citas de Hoy</h2>
                    <a href="{{ route('barber.appointments') }}" class="text-sm text-primary hover:underline">Ver todas</a>
                </div>
                <div class="space-y-4">
                    @forelse($todayAppointments as $appt)
                    <div class="flex items-center justify-between p-4 rounded-xl bg-cream dark:bg-secondary">
                        <div class="flex items-center gap-4">
                            <div class="text-center">
                                <div class="text-lg font-heading font-bold">{{ \Carbon\Carbon::parse($appt->start_time)->format('h:i') }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appt->start_time)->format('A') }}</div>
                            </div>
                            <div class="w-px h-12 bg-gray-200 dark:bg-gray-700"></div>
                            <div>
                                <h4 class="font-heading font-bold">{{ $appt->customer?->user?->name ?? $appt->customer_name }}</h4>
                                <p class="text-sm text-gray-500">{{ $appt->service?->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="badge-{{ $appt->status }}">{{ __(ucfirst($appt->status)) }}</span>
                            @if($appt->status === 'confirmed')
                                <form method="POST" action="{{ route('barber.appointments.start', $appt) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button class="px-3 py-1.5 rounded-lg text-xs font-medium bg-primary text-white hover:bg-primary-dark transition-colors">Iniciar</button>
                                </form>
                            @endif
                            @if($appt->status === 'in_progress')
                                <form method="POST" action="{{ route('barber.appointments.complete', $appt) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button class="px-3 py-1.5 rounded-lg text-xs font-medium bg-green-600 text-white hover:bg-green-700 transition-colors">Completar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-gray-400">No tienes citas programadas para hoy.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h2 class="text-xl font-heading font-bold mb-6">Resumen Semanal</h2>
                <div class="space-y-3">
                    @foreach($weekSummary as $day)
                    <div class="flex items-center justify-between p-3 rounded-lg {{ $day['is_today'] ? 'bg-primary/10 border border-primary/20' : 'bg-gray-50 dark:bg-gray-800/50' }}">
                        <div>
                            <span class="text-sm font-medium">{{ $day['name'] }}</span>
                            <span class="text-xs text-gray-500 ml-2">{{ $day['date'] }}</span>
                        </div>
                        <span class="text-sm font-semibold {{ $day['count'] > 0 ? 'text-primary' : 'text-gray-400' }}">
                            {{ $day['count'] }} citas
                        </span>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('barber.schedule') }}" class="btn-outline w-full text-center mt-6 text-sm">Gestionar Horario</a>
            </div>
        </div>
    </div>
@endsection
