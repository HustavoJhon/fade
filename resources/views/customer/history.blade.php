@extends('layouts.customer')

@section('title', 'Mi Historial')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-heading font-bold text-zinc-900 dark:text-white mb-8">Mi Historial</h1>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 text-center">
                <div class="text-3xl font-heading font-bold text-zinc-900 dark:text-white">{{ $totalAppointments ?? 0 }}</div>
                <p class="text-sm text-zinc-500 mt-1">Citas Realizadas</p>
            </div>
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 text-center">
                <div class="text-3xl font-heading font-bold text-zinc-900 dark:text-white">${{ number_format($totalSpent ?? 0, 0) }}</div>
                <p class="text-sm text-zinc-500 mt-1">Total Gastado</p>
            </div>
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5 text-center">
                <div class="text-3xl font-heading font-bold {{ ($totalAppointments ?? 0) > 0 ? 'text-primary' : 'text-zinc-500' }}">{{ ($totalAppointments ?? 0) > 0 ? 'Recurrente' : 'Nuevo' }}</div>
                <p class="text-sm text-zinc-500 mt-1">Tipo de Cliente</p>
            </div>
        </div>

        {{-- Appointments Timeline --}}
        <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-6 mb-8">
            <h2 class="text-sm font-semibold text-zinc-900 dark:text-white mb-6">Historial de Citas</h2>
            <div class="space-y-4">
                @forelse($appointments as $appt)
                <div class="relative pl-8 pb-4 border-l-2 border-zinc-200 dark:border-white/10 last:pb-0">
                    <div class="absolute left-0 top-1 -translate-x-1/2 w-3.5 h-3.5 rounded-full bg-primary border-2 border-white dark:border-secondary"></div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <h4 class="font-heading font-bold text-zinc-900 dark:text-white">{{ $appt->service?->name }}</h4>
                            <p class="text-xs text-zinc-500">{{ $appt->barber?->user?->name }} • {{ $appt->start_time?->format('d/m/Y') }} a las {{ $appt->start_time?->format('h:i A') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="badge-{{ $appt->status }} text-xs">{{ ucfirst($appt->status) }}</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">${{ number_format($appt->total_price, 0) }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 text-sm text-zinc-500">No hay citas en tu historial.</div>
                @endforelse
            </div>
        </div>

        {{-- Payments --}}
        <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-6">
            <h2 class="text-sm font-semibold text-zinc-900 dark:text-white mb-6">Historial de Pagos</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b border-zinc-100 dark:border-white/5">
                            <th class="pb-3 font-medium text-xs text-zinc-500 uppercase tracking-wider">Fecha</th>
                            <th class="pb-3 font-medium text-xs text-zinc-500 uppercase tracking-wider">Servicio</th>
                            <th class="pb-3 font-medium text-xs text-zinc-500 uppercase tracking-wider">Método</th>
                            <th class="pb-3 font-medium text-xs text-zinc-500 uppercase tracking-wider">Monto</th>
                            <th class="pb-3 font-medium text-xs text-zinc-500 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr class="border-b border-zinc-50 dark:border-white/5">
                            <td class="py-3 text-zinc-600 dark:text-zinc-400">{{ $payment->created_at?->format('d/m/Y') }}</td>
                            <td class="py-3 text-zinc-900 dark:text-white">{{ $payment->appointment?->service?->name ?? '—' }}</td>
                            <td class="py-3 capitalize text-zinc-500">{{ $payment->payment_method ?? 'Efectivo' }}</td>
                            <td class="py-3 font-medium text-zinc-900 dark:text-white">${{ number_format($payment->amount, 0) }}</td>
                            <td class="py-3">
                                <span class="badge-active text-xs">{{ $payment->status ?? 'Completado' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-10 text-center text-sm text-zinc-500">No hay pagos registrados</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection