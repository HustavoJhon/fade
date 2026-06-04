<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold">Configuración</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Administra la configuración del negocio.</p>
        </div>
    </div>

    @if(session('message'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800 text-sm">{{ session('message') }}</div>
    @endif

    <form wire:submit="update" class="space-y-6">
        <div class="card">
            <h3 class="font-heading font-bold text-lg mb-6">Información del Negocio</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nombre del Negocio</label>
                    <input type="text" wire:model="business_name" class="input-field" placeholder="FADE Barbería">
                    @error('business_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Teléfono</label>
                    <input type="tel" wire:model="business_phone" class="input-field" placeholder="+1 (555) 000-0000">
                    @error('business_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Dirección</label>
                <input type="text" wire:model="business_address" class="input-field" placeholder="Calle 123, Ciudad">
                @error('business_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Email</label>
                <input type="email" wire:model="business_email" class="input-field" placeholder="info@fadebarberia.com">
                @error('business_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Descripción</label>
                <textarea wire:model="business_description" rows="3" class="input-field" placeholder="Descripción del negocio..."></textarea>
                @error('business_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="card">
            <h3 class="font-heading font-bold text-lg mb-6">Redes Sociales</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Facebook</label>
                    <input type="url" wire:model="social_facebook" class="input-field" placeholder="https://facebook.com/fade">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Instagram</label>
                    <input type="url" wire:model="social_instagram" class="input-field" placeholder="https://instagram.com/fade">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">TikTok</label>
                    <input type="url" wire:model="social_tiktok" class="input-field" placeholder="https://tiktok.com/@fade">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Twitter / X</label>
                    <input type="url" wire:model="social_twitter" class="input-field" placeholder="https://twitter.com/fade">
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="font-heading font-bold text-lg mb-6">Horarios de Atención</h3>
            <div class="space-y-4">
                @php
                    $days = ['monday' => 'Lunes', 'tuesday' => 'Martes', 'wednesday' => 'Miércoles', 'thursday' => 'Jueves', 'friday' => 'Viernes', 'saturday' => 'Sábado', 'sunday' => 'Domingo'];
                @endphp
                @foreach($days as $key => $label)
                <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 dark:bg-white/5">
                    <span class="w-24 text-sm font-medium">{{ $label }}</span>
                    <input type="time" wire:model="{{ $key }}_open" class="input-field !py-2 !w-32">
                    <span class="text-gray-400">a</span>
                    <input type="time" wire:model="{{ $key }}_close" class="input-field !py-2 !w-32">
                </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <h3 class="font-heading font-bold text-lg mb-6">Logo</h3>
            @if($logo)
                <div class="mb-4">
                    <img src="{{ Storage::url($logo) }}" class="h-20 rounded-xl border border-gray-200 dark:border-gray-700">
                </div>
            @endif
            <div>
                <label class="block text-sm font-medium mb-2">Subir Nuevo Logo</label>
                <input type="file" wire:model="newLogo" class="input-field" accept="image/*">
                @error('newLogo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @if($newLogo)
                    <div class="mt-2">
                        <button type="button" wire:click="saveLogo" class="btn-primary text-sm !py-2">Guardar Logo</button>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Guardar Configuración</button>
        </div>
    </form>
</div>
