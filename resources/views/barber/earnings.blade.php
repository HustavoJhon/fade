@extends('layouts.admin')

@section('title', 'Mis Ganancias')

@section('content')
    <div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-heading font-bold">Mis Ganancias</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Resumen de tus ingresos y comisiones.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="card">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-500">Total Ganado</span>
                    <div class="w-9 h-9 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-heading font-bold text-green-500">${{ number_format($totalEarned, 0) }}</div>
            </div>
            <div class="card">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-500">Este Mes</span>
                    <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-heading font-bold text-blue-500">${{ number_format($monthEarned, 0) }}</div>
            </div>
            <div class="card">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-500">Comisión</span>
                    <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-heading font-bold text-primary">{{ $commissionRate }}%</div>
                <div class="text-xs text-gray-500 mt-1">Tu tasa de comisión actual</div>
            </div>
        </div>

        <form method="GET" action="{{ route('barber.earnings') }}" class="card mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div>
                    <label class="block text-xs font-medium mb-1">Periodo</label>
                    <select name="period" class="input-field !py-2 text-sm" onchange="this.form.submit()">
                        <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Hoy</option>
                        <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Esta Semana</option>
                        <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Este Mes</option>
                        <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Este Año</option>
                        <option value="all" {{ request('period') === 'all' || !request('period') ? 'selected' : '' }}>Todo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Desde</label>
                    <input type="date" name="dateFrom" value="{{ request('dateFrom') }}" class="input-field !py-2 text-sm" onchange="this.form.submit()">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Hasta</label>
                    <input type="date" name="dateTo" value="{{ request('dateTo') }}" class="input-field !py-2 text-sm" onchange="this.form.submit()">
                </div>
            </div>
        </form>

        <div class="card overflow-hidden">
            <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="font-heading font-bold">Citas con Detalle de Comisión</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <th class="p-4 font-semibold text-gray-500">Fecha</th>
                            <th class="p-4 font-semibold text-gray-500">Cliente</th>
                            <th class="p-4 font-semibold text-gray-500">Servicio</th>
                            <th class="p-4 font-semibold text-gray-500">Total</th>
                            <th class="p-4 font-semibold text-gray-500">Comisión</th>
                            <th class="p-4 font-semibold text-gray-500">Ganancia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appt)
                        <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-800/30">
                            <td class="p-4">{{ \Carbon\Carbon::parse($appt->start_time)->format('d/m/Y') }}</td>
                            <td class="p-4 font-medium">{{ $appt->customer?->user?->name ?? $appt->customer_name }}</td>
                            <td class="p-4">{{ $appt->service?->name }}</td>
                            <td class="p-4">${{ number_format($appt->total_price, 0) }}</td>
                            <td class="p-4 text-gray-500">{{ $commissionRate }}%</td>
                            <td class="p-4 font-medium text-green-600">${{ number_format($appt->total_price * $commissionRate / 100, 0) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="p-12 text-center text-gray-400">No hay citas completadas en este periodo</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($appointments->hasPages())
                <div class="p-4 border-t border-gray-100 dark:border-gray-700">{{ $appointments->links() }}</div>
            @endif
        </div>

        <div class="card mt-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="p-4 bg-cream dark:bg-secondary rounded-xl">
                    <span class="text-sm text-gray-500">Total de Servicios en Periodo</span>
                    <div class="text-2xl font-heading font-bold mt-1">{{ $appointments->total() ?? 0 }}</div>
                </div>
                <div class="p-4 bg-cream dark:bg-secondary rounded-xl">
                    <span class="text-sm text-gray-500">Comisión Total del Periodo</span>
                    <div class="text-2xl font-heading font-bold text-primary mt-1">${{ number_format($periodCommission, 0) }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
