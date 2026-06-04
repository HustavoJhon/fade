@extends('layouts.admin')

@section('title', 'Mi Horario')

@section('content')
    <div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-heading font-bold">Mi Horario</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Gestiona tu disponibilidad semanal.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800 text-sm">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('barber.schedule.update') }}" class="card mb-6">
            @csrf
            <div class="flex items-center gap-3 p-4">
                <input type="checkbox" name="available" value="1" id="available" {{ $barber?->is_active ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary">
                <label for="available" class="font-medium">Disponible para nuevas citas</label>
            </div>
            <div class="px-4 pb-4">
                <button type="submit" class="btn-primary text-sm">Guardar</button>
            </div>
        </form>

        <div class="card">
            <h2 class="text-xl font-heading font-bold mb-6">Excepciones (Días no laborables)</h2>
            <div class="space-y-3">
                @forelse($exceptions as $exc)
                <div class="flex items-center justify-between p-4 rounded-lg bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30">
                    <div>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($exc->date)->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-500">{{ $exc->reason ?? 'Día libre' }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 py-6">No hay excepciones registradas. Contacta al administrador para gestionar tus días libres.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
