<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold">Reportes</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Genera y exporta reportes del negocio.</p>
        </div>
    </div>

    <div class="card mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-medium mb-1">Tipo de Reporte</label>
                <select wire:model.live="reportType" class="input-field !py-2 text-sm">
                    <option value="sales">Ventas</option>
                    <option value="appointments">Citas</option>
                    <option value="customers">Clientes</option>
                    <option value="barbers">Barberos</option>
                    <option value="finance">Finanzas</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Desde</label>
                <input type="date" wire:model.live="dateFrom" class="input-field !py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Hasta</label>
                <input type="date" wire:model.live="dateTo" class="input-field !py-2 text-sm">
            </div>
            <div class="flex items-end gap-2">
                <button wire:click="generatePDF(reportType)" class="btn-primary text-sm !py-2 flex-1">PDF</button>
                <button wire:click="generateExcel(reportType)" class="btn-outline text-sm !py-2 flex-1">Excel</button>
            </div>
        </div>
        @if(in_array($reportType, ['appointments', 'barbers']))
        <div class="mt-4">
            <label class="block text-xs font-medium mb-1">Barbero (opcional)</label>
            <select wire:model.live="barberId" class="input-field !py-2 text-sm">
                <option value="">Todos los barberos</option>
                @foreach($barbers as $b)
                    <option value="{{ $b->id }}">{{ $b->user->name }}</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>

    @if($reportType === 'sales' && isset($reportData['incomes']))
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="card text-center">
            <div class="text-sm text-gray-500">Total Ingresos</div>
            <div class="text-2xl font-heading font-bold text-green-500">${{ number_format($reportData['total'] ?? 0, 0) }}</div>
        </div>
        <div class="card text-center">
            <div class="text-sm text-gray-500">Por Categoría</div>
            <div class="text-sm mt-2">
                @foreach(($reportData['byCategory'] ?? collect()) as $cat => $amount)
                <div class="flex justify-between py-1"><span>{{ $cat }}</span><span class="font-medium">${{ number_format($amount, 0) }}</span></div>
                @endforeach
            </div>
        </div>
        <div class="card text-center">
            <div class="text-sm text-gray-500">Por Método de Pago</div>
            <div class="text-sm mt-2">
                @foreach(($reportData['byPaymentMethod'] ?? collect()) as $method => $amount)
                <div class="flex justify-between py-1"><span>{{ $method ?: 'Efectivo' }}</span><span class="font-medium">${{ number_format($amount, 0) }}</span></div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead><tr class="text-left border-b bg-gray-50 dark:bg-gray-800/50"><th class="p-3 font-semibold">Fecha</th><th class="p-3 font-semibold">Descripción</th><th class="p-3 font-semibold">Categoría</th><th class="p-3 font-semibold">Monto</th></tr></thead>
            <tbody>
                @foreach($reportData['incomes'] as $inc)
                <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-800/30">
                    <td class="p-3">{{ $inc->recorded_at->format('d/m/Y') }}</td>
                    <td class="p-3">{{ $inc->description }}</td>
                    <td class="p-3">{{ $inc->category }}</td>
                    <td class="p-3 font-medium">${{ number_format($inc->amount, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @elseif($reportType === 'appointments' && isset($reportData['appointments']))
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="card text-center"><div class="text-sm text-gray-500">Total</div><div class="text-2xl font-heading font-bold">{{ $reportData['total'] }}</div></div>
        <div class="card text-center"><div class="text-sm text-gray-500">Ingresos</div><div class="text-2xl font-heading font-bold text-green-500">${{ number_format($reportData['revenue'] ?? 0, 0) }}</div></div>
        <div class="card text-center"><div class="text-sm text-gray-500">Por Estado</div><div class="text-sm mt-2">@foreach(($reportData['byStatus'] ?? collect()) as $s => $c)<div class="flex justify-between py-0.5"><span>{{ ucfirst($s) }}</span><span>{{ $c }}</span></div>@endforeach</div></div>
        <div class="card text-center"><div class="text-sm text-gray-500">Por Barbero</div><div class="text-sm mt-2">@foreach(($reportData['byBarber'] ?? collect()) as $b => $c)<div class="flex justify-between py-0.5"><span>{{ $b }}</span><span>{{ $c }}</span></div>@endforeach</div></div>
    </div>

    @elseif($reportType === 'customers' && isset($reportData['customers']))
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="card text-center"><div class="text-sm text-gray-500">Nuevos Clientes</div><div class="text-2xl font-heading font-bold">{{ $reportData['newCustomers'] ?? 0 }}</div></div>
        <div class="card text-center"><div class="text-sm text-gray-500">Clientes Activos</div><div class="text-2xl font-heading font-bold">{{ $reportData['activeCustomers'] ?? 0 }}</div></div>
        <div class="card text-center"><div class="text-sm text-gray-500">Total</div><div class="text-2xl font-heading font-bold">{{ count($reportData['customers']) }}</div></div>
    </div>

    @elseif($reportType === 'barbers' && isset($reportData['barbers']))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        @foreach($reportData['barbers'] as $b)
        <div class="card">
            <div class="font-heading font-bold text-lg">{{ $b->name }}</div>
            <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                <div><span class="text-gray-500">Citas:</span> {{ $b->total_appointments }}</div>
                <div><span class="text-gray-500">Completadas:</span> {{ $b->completed }}</div>
                <div><span class="text-gray-500">Canceladas:</span> {{ $b->cancelled }}</div>
                <div><span class="text-gray-500">Ingresos:</span> ${{ number_format($b->revenue, 0) }}</div>
                <div><span class="text-gray-500">Valoración:</span> {{ $b->avg_rating ? number_format($b->avg_rating, 1) : '—' }}</div>
            </div>
        </div>
        @endforeach
    </div>

    @elseif($reportType === 'finance' && isset($reportData['incomes']))
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="card text-center"><div class="text-sm text-gray-500">Ingresos</div><div class="text-2xl font-heading font-bold text-green-500">${{ number_format($reportData['incomes'] ?? 0, 0) }}</div></div>
        <div class="card text-center"><div class="text-sm text-gray-500">Gastos</div><div class="text-2xl font-heading font-bold text-red-500">${{ number_format($reportData['expenses'] ?? 0, 0) }}</div></div>
        <div class="card text-center"><div class="text-sm text-gray-500">Balance</div><div class="text-2xl font-heading font-bold {{ ($reportData['balance'] ?? 0) >= 0 ? 'text-green-500' : 'text-red-500' }}">${{ number_format($reportData['balance'] ?? 0, 0) }}</div></div>
    </div>
    <div class="card p-4">
        <h4 class="font-heading font-bold mb-3">Ingresos por Categoría</h4>
        <div class="space-y-2">@foreach(($reportData['incomesByCategory'] ?? collect()) as $cat => $amount)<div class="flex justify-between text-sm"><span>{{ $cat }}</span><span class="font-medium">${{ number_format($amount, 0) }}</span></div>@endforeach</div>
        <h4 class="font-heading font-bold mt-4 mb-3">Gastos por Categoría</h4>
        <div class="space-y-2">@foreach(($reportData['expensesByCategory'] ?? collect()) as $cat => $amount)<div class="flex justify-between text-sm"><span>{{ $cat }}</span><span class="font-medium">${{ number_format($amount, 0) }}</span></div>@endforeach</div>
    </div>
    @endif
</div>
