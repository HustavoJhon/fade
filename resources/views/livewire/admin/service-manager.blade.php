<div x-data="{ open: false }">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold">Servicios</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Gestiona los servicios ofrecidos.</p>
        </div>
        <button wire:click="create" x-on:click="open = true" class="btn-primary text-sm !py-2.5 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Nuevo Servicio
        </button>
    </div>

    <div class="card mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <input type="text" wire:model.live="search" class="input-field" placeholder="Buscar servicio...">
            <select wire:model.live="categoryFilter" class="input-field">
                <option value="">Todas las categorías</option>
                @foreach($this->categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <th class="p-4 font-semibold text-gray-500">Servicio</th>
                        <th class="p-4 font-semibold text-gray-500">Categoría</th>
                        <th class="p-4 font-semibold text-gray-500">Precio</th>
                        <th class="p-4 font-semibold text-gray-500">Duración</th>
                        <th class="p-4 font-semibold text-gray-500">Estado</th>
                        <th class="p-4 font-semibold text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($service->image)
                                        <img src="{{ Storage::url($service->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                    @endif
                                </div>
                                <span class="font-medium">{{ $service->name }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-gray-500">{{ $service->category?->name ?? '—' }}</td>
                        <td class="p-4 font-medium">${{ number_format($service->price, 0) }}</td>
                        <td class="p-4">{{ $service->duration }} min</td>
                        <td class="p-4">
                            <span class="badge-{{ $service->is_active ? 'active' : 'inactive' }}">
                                {{ $service->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <button wire:click="edit({{ $service->id }})" x-on:click="open = true" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-blue-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button wire:click="destroy({{ $service->id }})" onclick="return confirm('¿Eliminar este servicio?')" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-12 text-center text-gray-400">No se encontraron servicios</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($services->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">{{ $services->links() }}</div>
        @endif
    </div>

    <div x-show="open || $wire.editingServiceId" x-cloak class="modal-overlay">
        <div class="modal-content p-6" @click.away="if(!$wire.editingServiceId) open = false">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-heading font-bold">{{ $editingServiceId ? 'Editar Servicio' : 'Nuevo Servicio' }}</h3>
                <button @click="open = false; $wire.resetInputFields()" class="text-gray-400 hover:text-secondary dark:hover:text-cream">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form wire:submit="{{ $editingServiceId ? 'update' : 'store' }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nombre</label>
                        <input type="text" wire:model="name" class="input-field" placeholder="Nombre del servicio">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Categoría</label>
                        <select wire:model="category_id" class="input-field">
                            <option value="">Seleccionar categoría</option>
                            @foreach($this->categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Descripción</label>
                    <textarea wire:model="description" rows="2" class="input-field" placeholder="Descripción del servicio..."></textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Precio ($)</label>
                        <input type="number" wire:model="price" class="input-field" placeholder="25" min="0" step="0.01">
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Duración (min)</label>
                        <input type="number" wire:model="duration" class="input-field" placeholder="45" min="5">
                        @error('duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Imagen</label>
                        <input type="file" wire:model="newImage" class="input-field" accept="image/*">
                        @error('newImage') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary">
                    <label for="is_active" class="text-sm">Activo</label>
                </div>
                @if($image && !$newImage)
                <div class="text-xs text-gray-400">Imagen actual: {{ basename($image) }}</div>
                @endif
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="btn-primary flex-1">{{ $editingServiceId ? 'Actualizar' : 'Guardar' }}</button>
                    <button type="button" @click="open = false; $wire.resetInputFields()" class="btn-outline flex-1 text-center">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
