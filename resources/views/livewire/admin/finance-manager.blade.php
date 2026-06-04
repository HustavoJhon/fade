<div x-data="{ tab: 'incomes' }">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold">Finanzas</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Control de ingresos y egresos.</p>
        </div>
        <div class="flex gap-2">
            <button @click="tab = 'incomes'" :class="tab === 'incomes' ? 'btn-primary' : 'btn-outline'" class="text-sm !py-2">+ Ingreso</button>
            <button @click="tab = 'expenses'" :class="tab === 'expenses' ? 'btn-primary' : 'btn-outline'" class="text-sm !py-2">+ Gasto</button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm text-gray-500">Ingresos Totales</span>
                <div class="w-9 h-9 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-heading font-bold text-green-500">${{ number_format($this->totalIncome, 0) }}</div>
        </div>
        <div class="card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm text-gray-500">Gastos Totales</span>
                <div class="w-9 h-9 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-heading font-bold text-red-500">${{ number_format($this->totalExpense, 0) }}</div>
        </div>
        <div class="card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm text-gray-500">Balance</span>
                <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-heading font-bold text-blue-500">${{ number_format($this->balance, 0) }}</div>
        </div>
    </div>

    <div class="card mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div>
                <label class="block text-xs font-medium mb-1">Desde</label>
                <input type="date" wire:model.live="dateFrom" class="input-field !py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Hasta</label>
                <input type="date" wire:model.live="dateTo" class="input-field !py-2 text-sm">
            </div>
            <div class="flex items-end">
                <button wire:click="$set('dateFrom', null); $set('dateTo', null)" class="px-4 py-2 rounded-lg text-sm border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Limpiar</button>
            </div>
        </div>
    </div>

    <div class="flex gap-4 mb-6">
        <button @click="tab = 'incomes'" :class="tab === 'incomes' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'" class="pb-3 border-b-2 font-medium transition-colors">Ingresos</button>
        <button @click="tab = 'expenses'" :class="tab === 'expenses' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'" class="pb-3 border-b-2 font-medium transition-colors">Egresos</button>
    </div>

    <div x-show="tab === 'incomes'" class="card overflow-hidden">
        <div class="flex justify-end p-4">
            <button wire:click="createIncome" class="btn-primary text-sm !py-2">Registrar Ingreso</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <th class="p-4 font-semibold text-gray-500">Fecha</th>
                        <th class="p-4 font-semibold text-gray-500">Descripción</th>
                        <th class="p-4 font-semibold text-gray-500">Categoría</th>
                        <th class="p-4 font-semibold text-gray-500">Método</th>
                        <th class="p-4 font-semibold text-gray-500">Monto</th>
                        <th class="p-4 font-semibold text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($incomes as $inc)
                    <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-800/30">
                        <td class="p-4">{{ \Carbon\Carbon::parse($inc->recorded_at)->format('d/m/Y') }}</td>
                        <td class="p-4 font-medium">{{ $inc->description }}</td>
                        <td class="p-4 text-gray-500">{{ $inc->category ?? '—' }}</td>
                        <td class="p-4 text-gray-500">{{ $inc->payment_method ?? '—' }}</td>
                        <td class="p-4 font-medium text-green-600">+${{ number_format($inc->amount, 0) }}</td>
                        <td class="p-4">
                            <button wire:click="deleteIncome({{ $inc->id }})" onclick="return confirm('¿Eliminar?')" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-12 text-center text-gray-400">Sin ingresos registrados</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($incomes->hasPages())<div class="p-4 border-t border-gray-100 dark:border-gray-700">{{ $incomes->links() }}</div>@endif
    </div>

    <div x-show="tab === 'expenses'" class="card overflow-hidden">
        <div class="flex justify-end p-4">
            <button wire:click="createExpense" class="btn-primary text-sm !py-2">Registrar Gasto</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <th class="p-4 font-semibold text-gray-500">Fecha</th>
                        <th class="p-4 font-semibold text-gray-500">Descripción</th>
                        <th class="p-4 font-semibold text-gray-500">Categoría</th>
                        <th class="p-4 font-semibold text-gray-500">Monto</th>
                        <th class="p-4 font-semibold text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $exp)
                    <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-800/30">
                        <td class="p-4">{{ \Carbon\Carbon::parse($exp->recorded_at)->format('d/m/Y') }}</td>
                        <td class="p-4 font-medium">{{ $exp->description }}</td>
                        <td class="p-4 text-gray-500">{{ $exp->category ?? '—' }}</td>
                        <td class="p-4 font-medium text-red-600">-${{ number_format($exp->amount, 0) }}</td>
                        <td class="p-4">
                            <button wire:click="deleteExpense({{ $exp->id }})" onclick="return confirm('¿Eliminar?')" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-12 text-center text-gray-400">Sin egresos registrados</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($expenses->hasPages())<div class="p-4 border-t border-gray-100 dark:border-gray-700">{{ $expenses->links() }}</div>@endif
    </div>
</div>
