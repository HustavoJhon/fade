<div>
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold">Galería</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Gestiona las imágenes del portafolio.</p>
        </div>
    </div>

    <div class="card mb-6">
        <form wire:submit="upload" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Imagen</label>
                    <input type="file" wire:model="image" class="input-field" accept="image/*">
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Barbero (opcional)</label>
                    <select wire:model="barber_id" class="input-field">
                        <option value="">Seleccionar barbero</option>
                        @foreach($this->barbers as $barber)
                            <option value="{{ $barber->id }}">{{ $barber->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Descripción</label>
                    <input type="text" wire:model="caption" class="input-field" placeholder="Descripción de la imagen">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn-primary text-sm !py-2">Subir Imagen</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($galleryItems as $item)
        <div class="card p-2 group relative">
            <div class="aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800">
                <img src="{{ Storage::url($item->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $item->caption ?? 'Galería' }}">
            </div>
            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                <button wire:click="delete({{ $item->id }})" onclick="return confirm('¿Eliminar esta imagen?')" class="p-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @if($item->caption)
            <p class="text-xs text-gray-500 mt-2 truncate">{{ $item->caption }}</p>
            @endif
            @if($item->barber)
            <p class="text-xs text-gray-400">{{ $item->barber->user->name ?? '' }}</p>
            @endif
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-gray-400">No hay imágenes en la galería</div>
        @endforelse
    </div>

    @if($galleryItems->hasPages())
        <div class="mt-6">{{ $galleryItems->links() }}</div>
    @endif
</div>
