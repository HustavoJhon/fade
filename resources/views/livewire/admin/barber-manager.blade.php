<div x-data="{ open: false }">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold">Barberos</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Gestiona los barberos de tu equipo.</p>
        </div>
        <button wire:click="create" x-on:click="open = true" class="btn-primary text-sm !py-2.5 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Nuevo Barbero
        </button>
    </div>

    <div class="card mb-6">
        <input type="text" wire:model.live="search" class="input-field" placeholder="Buscar barbero...">
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <th class="p-4 font-semibold text-gray-500">Barbero</th>
                        <th class="p-4 font-semibold text-gray-500">Email</th>
                        <th class="p-4 font-semibold text-gray-500">Teléfono</th>
                        <th class="p-4 font-semibold text-gray-500">Especialidades</th>
                        <th class="p-4 font-semibold text-gray-500">Comisión</th>
                        <th class="p-4 font-semibold text-gray-500">Estado</th>
                        <th class="p-4 font-semibold text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barbers as $barber)
                    <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    <span class="font-bold text-primary">{{ substr($barber->user->name ?? 'B', 0, 1) }}</span>
                                </div>
                                <span class="font-medium">{{ $barber->user->name ?? 'Barbero' }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-gray-500">{{ $barber->user->email ?? '—' }}</td>
                        <td class="p-4 text-gray-500">{{ $barber->user->phone ?? '—' }}</td>
                        <td class="p-4">{{ is_array($barber->specialties) ? implode(', ', $barber->specialties) : ($barber->specialties ?: '—') }}</td>
                        <td class="p-4">{{ $barber->commission ?? 0 }}%</td>
                        <td class="p-4">
                            <button wire:click="toggleActive({{ $barber->id }})" class="badge-{{ $barber->is_active ? 'active' : 'inactive' }} cursor-pointer">
                                {{ $barber->is_active ? 'Activo' : 'Inactivo' }}
                            </button>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <button wire:click="edit({{ $barber->id }})" x-on:click="open = true" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-blue-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button wire:click="destroy({{ $barber->id }})" onclick="return confirm('¿Eliminar este barbero?')" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="p-12 text-center text-gray-400">No se encontraron barberos</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($barbers->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">{{ $barbers->links() }}</div>
        @endif
    </div>

    <div x-show="open || $wire.editingBarberId" x-cloak class="modal-overlay">
        <div class="modal-content p-6" @click.away="if(!$wire.editingBarberId) open = false">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-heading font-bold">{{ $editingBarberId ? 'Editar Barbero' : 'Nuevo Barbero' }}</h3>
                <button @click="open = false; $wire.resetInputFields()" class="text-gray-400 hover:text-secondary dark:hover:text-cream">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form wire:submit="{{ $editingBarberId ? 'update' : 'store' }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nombre</label>
                        <input type="text" wire:model="name" class="input-field" placeholder="Nombre del barbero">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" wire:model="email" class="input-field" placeholder="correo@ejemplo.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Contraseña <span class="text-xs text-gray-400">{{ $editingBarberId ? '(dejar vacío para mantener)' : '' }}</span></label>
                        <input type="password" wire:model="password" class="input-field" placeholder="{{ $editingBarberId ? '••••••••' : 'Contraseña' }}">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Teléfono</label>
                        <input type="tel" wire:model="phone" class="input-field" placeholder="+1 (555) 000-0000">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Comisión (%)</label>
                        <input type="number" wire:model="commission" class="input-field" placeholder="40" min="0" max="100">
                        @error('commission') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Especialidades</label>
                        <div class="space-y-2">
                            @foreach(['Cortes', 'Barbas', 'Degradados', 'Tintes', 'Peinados'] as $spec)
                            <label class="inline-flex items-center gap-2 text-sm">
                                <input type="checkbox" wire:model="specialties" value="{{ $spec }}" class="rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary">
                                {{ $spec }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Biografía</label>
                    <textarea wire:model="bio" rows="3" class="input-field" placeholder="Breve biografía del barbero..."></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary">
                    <label for="is_active" class="text-sm">Activo</label>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="btn-primary flex-1">{{ $editingBarberId ? 'Actualizar' : 'Guardar' }}</button>
                    <button type="button" @click="open = false; $wire.resetInputFields()" class="btn-outline flex-1 text-center">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
