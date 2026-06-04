<div>
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold">Citas</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Gestiona todas las citas de la barbería.</p>
        </div>
        <button wire:click="create" class="btn-primary text-sm !py-2.5 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Nueva Cita
        </button>
    </div>

    {{-- Filters --}}
    <div class="card mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <input type="text" wire:model.live="search" class="input-field" placeholder="Buscar cliente...">
            </div>
            <div>
                <select wire:model.live="statusFilter" class="input-field">
                    <option value="">Todos los estados</option>
                    <option value="pending">Pendiente</option>
                    <option value="confirmed">Confirmada</option>
                    <option value="in_progress">En Progreso</option>
                    <option value="completed">Completada</option>
                    <option value="cancelled">Cancelada</option>
                </select>
            </div>
            <div>
                <select wire:model.live="barberFilter" class="input-field">
                    <option value="">Todos los barberos</option>
                    @foreach($this->barbers as $barber)
                        <option value="{{ $barber->id }}">{{ $barber->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="date" wire:model.live="dateFilter" class="input-field">
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <th class="p-4 font-semibold text-gray-500">Cliente</th>
                        <th class="p-4 font-semibold text-gray-500">Barbero</th>
                        <th class="p-4 font-semibold text-gray-500">Servicio</th>
                        <th class="p-4 font-semibold text-gray-500">Fecha</th>
                        <th class="p-4 font-semibold text-gray-500">Hora</th>
                        <th class="p-4 font-semibold text-gray-500">Estado</th>
                        <th class="p-4 font-semibold text-gray-500">Precio</th>
                        <th class="p-4 font-semibold text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                        <td class="p-4 font-medium">{{ $appt->customer?->user?->name ?? $appt->customer_name ?? 'Walk-in' }}</td>
                        <td class="p-4">{{ $appt->barber?->user?->name ?? 'Sin asignar' }}</td>
                        <td class="p-4">{{ $appt->service?->name ?? '—' }}</td>
                        <td class="p-4">{{ \Carbon\Carbon::parse($appt->start_time)->format('d/m/Y') }}</td>
                        <td class="p-4">{{ \Carbon\Carbon::parse($appt->start_time)->format('h:i A') }}</td>
                        <td class="p-4">
                            <span class="badge-{{ $appt->status }}">{{ __(ucfirst($appt->status)) }}</span>
                        </td>
                        <td class="p-4 font-medium">${{ number_format($appt->total_price, 0) }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <button wire:click="$set('viewingAppointment', {{ $appt->id }})" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-primary transition-colors" title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button wire:click="edit({{ $appt->id }})" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-blue-500 transition-colors" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                @if(in_array($appt->status, ['pending', 'confirmed']))
                                <button wire:click="changeStatus({{ $appt->id }}, 'cancelled')" onclick="return confirm('¿Cancelar esta cita?')" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-red-500 transition-colors" title="Cancelar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                @endif
                                @if($appt->status === 'confirmed')
                                <button wire:click="changeStatus({{ $appt->id }}, 'completed')" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-green-500 transition-colors" title="Completar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </button>
                                @endif
                                @if(in_array($appt->status, ['pending', 'confirmed', 'in_progress']))
                                <button wire:click="destroy({{ $appt->id }})" onclick="return confirm('¿Eliminar esta cita permanentemente?')" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-red-500 transition-colors" title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="p-12 text-center text-gray-400">No se encontraron citas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appointments->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>

    {{-- Create/Edit Modal --}}
    <div x-cloak x-data="{ open: @entangle('editingAppointmentId') }" x-show="open !== null" class="modal-overlay">
        <div class="modal-content p-6" @click.away="if(!$wire.editingAppointmentId && !$wire.customer_id) open = null">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-heading font-bold">{{ $editingAppointmentId ? 'Editar Cita' : 'Nueva Cita' }}</h3>
                <button wire:click="resetInputFields" class="text-gray-400 hover:text-secondary dark:hover:text-cream">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form wire:submit="{{ $editingAppointmentId ? 'update' : 'store' }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Cliente</label>
                        <select wire:model="customer_id" class="input-field">
                            <option value="">Seleccionar cliente</option>
                            @foreach($this->customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->user->name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Barbero</label>
                        <select wire:model="barber_id" class="input-field">
                            <option value="">Seleccionar barbero</option>
                            @foreach($this->barbers as $barber)
                                <option value="{{ $barber->id }}">{{ $barber->user->name }}</option>
                            @endforeach
                        </select>
                        @error('barber_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Servicio</label>
                    <select wire:model="service_id" class="input-field">
                        <option value="">Seleccionar servicio</option>
                        @foreach($this->services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }} - ${{ number_format($service->price, 0) }}</option>
                        @endforeach
                    </select>
                    @error('service_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Fecha y Hora Inicio</label>
                        <input type="datetime-local" wire:model="start_time" class="input-field">
                        @error('start_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Fecha y Hora Fin</label>
                        <input type="datetime-local" wire:model="end_time" class="input-field">
                        @error('end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Estado</label>
                        <select wire:model="status" class="input-field">
                            <option value="pending">Pendiente</option>
                            <option value="confirmed">Confirmada</option>
                            <option value="in_progress">En Progreso</option>
                            <option value="completed">Completada</option>
                            <option value="cancelled">Cancelada</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Precio Total</label>
                        <input type="number" step="0.01" wire:model="total_price" class="input-field" placeholder="0.00">
                        @error('total_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Notas</label>
                    <textarea wire:model="notes" rows="3" class="input-field" placeholder="Notas opcionales..."></textarea>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="btn-primary flex-1">{{ $editingAppointmentId ? 'Actualizar' : 'Guardar' }}</button>
                    <button type="button" wire:click="resetInputFields" class="btn-outline flex-1 text-center">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
