<div x-data="{ open: false }">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-heading font-bold dark:text-white">Usuarios</h1>
            <p class="text-sm text-gray-500 mt-1">Gestión de usuarios del sistema.</p>
        </div>
        <div class="flex items-center gap-3 mt-4 sm:mt-0">
            <button class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-white/10 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Exportar
            </button>
            <button class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary text-white text-sm font-medium hover:bg-primary-dark transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Añadir Cliente
            </button>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white dark:bg-[#0f0f1a] rounded-xl border border-gray-200 dark:border-white/5 p-4 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
            <div class="relative flex-1 w-full">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                <input type="text" wire:model.live="search" class="w-full pl-9 pr-4 h-10 rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-transparent text-sm text-gray-900 dark:text-cream placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" placeholder="Buscar por nombre, email o teléfono...">
            </div>
            <select wire:model.live="status" class="h-10 px-3 rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-transparent text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                <option value="">Todos los estados</option>
                <option value="active">Activos</option>
                <option value="inactive">Inactivos</option>
                <option value="vip">VIP</option>
            </select>
            <select wire:model.live="perPage" class="h-10 px-3 rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-transparent text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                <option value="10">10 filas</option>
                <option value="15">15 filas</option>
                <option value="25">25 filas</option>
                <option value="50">50 filas</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-[#0f0f1a] rounded-xl border border-gray-200 dark:border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-200 dark:border-white/5 bg-gray-50 dark:bg-white/5">
                        <th class="px-5 py-3.5 font-medium text-xs text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-5 py-3.5 font-medium text-xs text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3.5 font-medium text-xs text-gray-500 uppercase tracking-wider">Teléfono</th>
                        <th class="px-5 py-3.5 font-medium text-xs text-gray-500 uppercase tracking-wider">Visitas</th>
                        <th class="px-5 py-3.5 font-medium text-xs text-gray-500 uppercase tracking-wider">Miembro Desde</th>
                        <th class="px-5 py-3.5 font-medium text-xs text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 text-sm font-bold text-primary">
                                    {{ substr($customer->user->name ?? 'C', 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium truncate max-w-[160px]">{{ $customer->user->name ?? 'Cliente' }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $customer->total_visits > 5 ? '🌟 Cliente frecuente' : '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $customer->user->email ?? '—' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $customer->user->phone ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <span class="font-semibold text-sm">{{ $customer->total_visits }}</span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $customer->created_at->format('M Y') }}</td>
                        <td class="px-5 py-4 text-right">
                            <button wire:click="view({{ $customer->id }})" x-on:click="open = true" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-primary transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center text-sm text-gray-400">No se encontraron clientes</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($customers->hasPages())
        <div class="flex items-center justify-between px-5 py-4 border-t border-gray-200 dark:border-white/5">
            <div class="text-xs text-gray-500">
                Mostrando {{ $customers->firstItem() }}–{{ $customers->lastItem() }} de {{ $customers->total() }} clientes
            </div>
            <div class="flex items-center gap-1">
                {{ $customers->links() }}
            </div>
        </div>
        @endif
    </div>

    {{-- Customer Detail Modal --}}
    <div x-show="open && $wire.viewingCustomerId" x-cloak class="modal-overlay">
        <div class="modal-content p-6 max-w-2xl" @click.away="if($wire.viewingCustomerId) open = false">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-heading font-bold">Detalle del Cliente</h3>
                <button @click="open = false; $wire.closeView()" class="text-gray-400 hover:text-secondary dark:hover:text-cream">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @if($this->customerHistory)
            <div class="mb-6 p-5 bg-gray-50 dark:bg-white/5 rounded-xl">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-xl bg-primary/10 flex items-center justify-center text-2xl font-heading font-bold text-primary">{{ substr($this->customerHistory->customer->user->name ?? 'C', 0, 1) }}</div>
                    <div>
                        <h4 class="font-heading font-bold text-lg">{{ $this->customerHistory->customer->user->name ?? 'Cliente' }}</h4>
                        <p class="text-sm text-gray-500">{{ $this->customerHistory->customer->user->email }}</p>
                        <p class="text-sm text-gray-500">{{ $this->customerHistory->customer->user->phone ?? '' }}</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="p-4 bg-gray-50 dark:bg-white/5 rounded-xl text-center">
                    <div class="text-2xl font-heading font-bold text-primary">{{ $this->customerHistory->totalVisits }}</div>
                    <div class="text-xs text-gray-500">Citas</div>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-white/5 rounded-xl text-center">
                    <div class="text-2xl font-heading font-bold text-primary">${{ number_format($this->customerHistory->totalSpent, 0) }}</div>
                    <div class="text-xs text-gray-500">Gastado</div>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-white/5 rounded-xl text-center">
                    <div class="text-2xl font-heading font-bold text-primary">{{ $this->customerHistory->averageRating ? number_format($this->customerHistory->averageRating, 1) : '—' }}</div>
                    <div class="text-xs text-gray-500">Valoración</div>
                </div>
            </div>
            <h4 class="font-heading font-bold mb-4">Historial de Citas</h4>
            <div class="space-y-3 max-h-60 overflow-y-auto">
                @forelse($this->customerHistory->appointments->take(10) as $appt)
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-white/5">
                    <div>
                        <p class="font-medium text-sm">{{ $appt->service?->name ?? '—' }}</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appt->start_time)->format('d/m/Y h:i A') }} • {{ $appt->barber?->user?->name ?? '—' }}</p>
                    </div>
                    <div class="text-right">
                        <span class="badge-{{ $appt->status }} text-xs">{{ __(ucfirst($appt->status)) }}</span>
                        <p class="text-xs font-medium mt-1">${{ number_format($appt->total_price, 0) }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 text-sm">Sin historial de citas</p>
                @endforelse
            </div>
            @endif
        </div>
    </div>
</div>