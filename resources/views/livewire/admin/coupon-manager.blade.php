<div x-data="{ open: false }">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold">Cupones</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Gestiona códigos de descuento y promociones.</p>
        </div>
        <button wire:click="create" x-on:click="open = true" class="btn-primary text-sm !py-2.5 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Nuevo Cupón
        </button>
    </div>

    <div class="card mb-6">
        <input type="text" wire:model.live="search" class="input-field" placeholder="Buscar por código...">
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <th class="p-4 font-semibold text-gray-500">Código</th>
                        <th class="p-4 font-semibold text-gray-500">Tipo</th>
                        <th class="p-4 font-semibold text-gray-500">Valor</th>
                        <th class="p-4 font-semibold text-gray-500">Mínimo</th>
                        <th class="p-4 font-semibold text-gray-500">Usos Máx</th>
                        <th class="p-4 font-semibold text-gray-500">Vence</th>
                        <th class="p-4 font-semibold text-gray-500">Estado</th>
                        <th class="p-4 font-semibold text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                    <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                        <td class="p-4 font-mono font-bold">{{ $coupon->code }}</td>
                        <td class="p-4">{{ $coupon->discount_type === 'percentage' ? 'Porcentaje' : 'Fijo' }}</td>
                        <td class="p-4 font-medium">{{ $coupon->discount_type === 'percentage' ? $coupon->discount_value . '%' : '$' . number_format($coupon->discount_value, 0) }}</td>
                        <td class="p-4 text-gray-500">{{ $coupon->min_appointment_amount ? '$' . number_format($coupon->min_appointment_amount, 0) : '—' }}</td>
                        <td class="p-4">{{ $coupon->max_uses ?? '∞' }}</td>
                        <td class="p-4 text-gray-500">{{ $coupon->expires_at ? $coupon->expires_at->format('d/m/Y') : '—' }}</td>
                        <td class="p-4">
                            <span class="badge-{{ $coupon->is_active ? 'active' : 'inactive' }}">{{ $coupon->is_active ? 'Activo' : 'Inactivo' }}</span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <button wire:click="edit({{ $coupon->id }})" x-on:click="open = true" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-blue-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button wire:click="destroy({{ $coupon->id }})" onclick="return confirm('¿Eliminar este cupón?')" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="p-12 text-center text-gray-400">No se encontraron cupones</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($coupons->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">{{ $coupons->links() }}</div>
        @endif
    </div>

    <div x-show="open || $wire.editingCouponId" x-cloak class="modal-overlay">
        <div class="modal-content p-6" @click.away="if(!$wire.editingCouponId) open = false">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-heading font-bold">{{ $editingCouponId ? 'Editar Cupón' : 'Nuevo Cupón' }}</h3>
                <button @click="open = false; $wire.resetInputFields()" class="text-gray-400 hover:text-secondary dark:hover:text-cream">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form wire:submit="{{ $editingCouponId ? 'update' : 'store' }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Código</label>
                        <input type="text" wire:model="code" class="input-field font-mono" placeholder="DESCUENTO10" style="text-transform: uppercase">
                        @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Tipo</label>
                        <select wire:model="discount_type" class="input-field">
                            <option value="percentage">Porcentaje (%)</option>
                            <option value="fixed">Monto Fijo ($)</option>
                        </select>
                        @error('discount_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Valor</label>
                        <input type="number" wire:model="discount_value" class="input-field" placeholder="10" min="0" step="0.01">
                        @error('discount_value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Monto Mínimo</label>
                        <input type="number" wire:model="min_appointment_amount" class="input-field" placeholder="0" min="0" step="0.01">
                        @error('min_appointment_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Usos Máximos</label>
                        <input type="number" wire:model="max_uses" class="input-field" placeholder="Sin límite" min="1">
                        @error('max_uses') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Fecha de Expiración</label>
                    <input type="date" wire:model="expires_at" class="input-field">
                    @error('expires_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary">
                    <label for="is_active" class="text-sm">Activo</label>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="btn-primary flex-1">{{ $editingCouponId ? 'Actualizar' : 'Guardar' }}</button>
                    <button type="button" @click="open = false; $wire.resetInputFields()" class="btn-outline flex-1 text-center">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
