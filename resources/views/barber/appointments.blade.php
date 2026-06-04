@extends('layouts.admin')

@section('title', 'Mis Citas')

@section('content')
    <div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-heading font-bold">Mis Citas</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Gestiona tus citas asignadas.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800 text-sm">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('barber.appointments') }}" class="card mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <select name="status" class="input-field !w-auto" onchange="this.form.submit()">
                    <option value="">Todos los estados</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmada</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completada</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                </select>
                <input type="date" name="date" value="{{ request('date') }}" class="input-field !w-auto" onchange="this.form.submit()">
                @if(request('status') || request('date'))
                <a href="{{ route('barber.appointments') }}" class="px-4 py-2 rounded-lg text-sm border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Limpiar</a>
                @endif
            </div>
        </form>

        <div class="space-y-4">
            @forelse($appointments as $appt)
            <div class="card flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="text-center min-w-[60px]">
                        <div class="text-2xl font-heading font-bold">{{ \Carbon\Carbon::parse($appt->start_time)->format('h:i') }}</div>
                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appt->start_time)->format('A') }}</div>
                        <div class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($appt->start_time)->format('d/m') }}</div>
                    </div>
                    <div class="w-px h-14 bg-gray-200 dark:bg-gray-700 hidden sm:block"></div>
                    <div>
                        <h3 class="font-heading font-bold">{{ $appt->customer?->user?->name ?? $appt->customer_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $appt->service?->name }}</p>
                        <p class="text-xs text-gray-400 mt-1">${{ number_format($appt->total_price, 0) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <span class="badge-{{ $appt->status }}">{{ __(ucfirst($appt->status)) }}</span>
                    @if($appt->status === 'confirmed')
                        <form method="POST" action="{{ route('barber.appointments.start', $appt) }}" class="inline">
                            @csrf @method('PATCH')
                            <button class="btn-primary text-sm !py-2">Iniciar</button>
                        </form>
                    @endif
                    @if($appt->status === 'in_progress')
                        <form method="POST" action="{{ route('barber.appointments.complete', $appt) }}" class="inline">
                            @csrf @method('PATCH')
                            <button class="px-4 py-2 rounded-lg text-sm font-medium bg-green-600 text-white hover:bg-green-700 transition-colors">Completar</button>
                        </form>
                    @endif
                    @if(in_array($appt->status, ['pending', 'confirmed']))
                        <form method="POST" action="{{ route('barber.appointments.cancel', $appt) }}" class="inline" onsubmit="return confirm('¿Cancelar esta cita?')">
                            @csrf @method('PATCH')
                            <button class="px-4 py-2 rounded-lg text-sm font-medium border border-red-200 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">Cancelar</button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="card text-center py-16">
                <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-gray-400">No se encontraron citas.</p>
            </div>
            @endforelse
        </div>

        @if($appointments->hasPages())
            <div class="mt-6">{{ $appointments->links() }}</div>
        @endif
    </div>
@endsection
