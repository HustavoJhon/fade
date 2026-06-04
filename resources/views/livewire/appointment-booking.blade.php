<div x-data="{ step: @entangle('step') }" class="min-h-screen pt-24 pb-16 bg-cream dark:bg-secondary">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-heading font-bold">Reserva tu <span class="gold-text">Cita</span></h1>
            <p class="text-gray-500 dark:text-gray-400 mt-3">En 4 sencillos pasos tendrás tu cita confirmada.</p>
        </div>

        {{-- Step Indicators --}}
        <div class="flex items-center justify-center mb-12">
            <template x-for="(s, i) in ['Servicio', 'Barbero', 'Fecha y Hora', 'Confirmar']" :key="i">
                <div class="flex items-center">
                    <div class="flex flex-col items-center">
                        <div :class="step > i + 1 ? 'step-circle step-circle-completed' : step === i + 1 ? 'step-circle step-circle-active' : 'step-circle step-circle-inactive'">
                            <template x-if="step > i + 1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="step <= i + 1">
                                <span x-text="i + 1"></span>
                            </template>
                        </div>
                        <span class="text-xs mt-2 font-medium" :class="step === i + 1 ? 'text-primary' : 'text-gray-400'" x-text="s"></span>
                    </div>
                    <template x-if="i < 3">
                        <div :class="step > i + 1 ? 'bg-primary' : 'bg-gray-200 dark:bg-gray-700'" class="w-12 sm:w-20 h-0.5 mx-2 sm:mx-4 -mt-6 transition-colors"></div>
                    </template>
                </div>
            </template>
        </div>

        <div class="card p-6 md:p-10">
            {{-- Step 1: Service Selection --}}
            <div x-show="step === 1" x-transition:enter="transition-all duration-300">
                <h2 class="text-2xl font-heading font-bold mb-2">Selecciona tu Servicio</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8">Elige el servicio que deseas.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($services as $service)
                    <button wire:click="selectService({{ $service->id }})" class="relative text-left p-5 rounded-xl border-2 transition-all {{ $selectedService === $service->id ? 'border-primary bg-primary/5' : 'border-gray-200 dark:border-gray-700 hover:border-primary/50' }}">
                        @if($service->duration <= 20)
                            <span class="absolute -top-2.5 right-3 bg-primary text-white text-xs font-bold px-2 py-0.5 rounded-full">Rápido</span>
                        @endif
                        <h3 class="font-heading font-bold text-lg">{{ $service->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $service->description }}</p>
                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100 dark:border-gray-700">
                            <span class="text-xl font-heading font-bold text-primary">${{ number_format($service->price, 0) }}</span>
                            <span class="text-sm text-gray-400">{{ $service->duration }} min</span>
                        </div>
                    </button>
                    @endforeach
                </div>
                @error('selectedService')
                    <p class="text-red-500 text-sm mt-3">{{ $message }}</p>
                @enderror
            </div>

            {{-- Step 2: Barber Selection --}}
            <div x-show="step === 2" x-transition:enter="transition-all duration-300">
                <h2 class="text-2xl font-heading font-bold mb-2">Elige tu Barbero</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8">Selecciona al barbero de tu preferencia.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($barbers as $barber)
                    <button wire:click="selectBarber({{ $barber->id }})" class="text-center p-6 rounded-xl border-2 transition-all {{ $selectedBarber === $barber->id ? 'border-primary bg-primary/5' : 'border-gray-200 dark:border-gray-700 hover:border-primary/50' }}">
                        <div class="w-20 h-20 rounded-full bg-primary/10 mx-auto flex items-center justify-center overflow-hidden">
                            @if($barber->user?->avatar)
                                <img src="{{ Storage::url($barber->user->avatar) }}" alt="{{ $barber->user->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl font-heading font-bold text-primary">{{ substr($barber->user->name ?? 'B', 0, 1) }}</span>
                            @endif
                        </div>
                        <h3 class="font-heading font-bold mt-4">{{ $barber->user->name ?? 'Barbero' }}</h3>
                        <p class="text-sm text-primary">{{ is_array($barber->specialties) ? implode(', ', $barber->specialties) : ($barber->specialties ?: 'Barbero') }}</p>
                    </button>
                    @endforeach
                </div>
                @error('selectedBarber')
                    <p class="text-red-500 text-sm mt-3">{{ $message }}</p>
                @enderror
            </div>

            {{-- Step 3: Date + Time --}}
            <div x-show="step === 3" x-transition:enter="transition-all duration-300">
                <h2 class="text-2xl font-heading font-bold mb-2">Fecha y Hora</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8">Selecciona el día y horario disponibles.</p>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-medium mb-3">Fecha</label>
                        <input type="date" wire:model.live="selectedDate" class="input-field" min="{{ date('Y-m-d') }}">
                        @error('selectedDate')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-3">Horario Disponible</label>
                        @if($availableSlots && count($availableSlots) > 0)
                            <div class="grid grid-cols-3 gap-2">
                                @foreach($availableSlots as $slot)
                                    <button wire:click="selectTime('{{ $slot }}')" class="py-3 px-4 rounded-lg border-2 text-sm font-medium transition-all {{ $selectedTime === $slot ? 'border-primary bg-primary/10 text-primary' : 'border-gray-200 dark:border-gray-700 hover:border-primary/50' }}">
                                        {{ $slot }}
                                    </button>
                                @endforeach
                            </div>
                        @elseif($selectedDate)
                            <p class="text-gray-400 text-sm">No hay horarios disponibles para esta fecha.</p>
                        @else
                            <p class="text-gray-400 text-sm">Selecciona una fecha para ver horarios.</p>
                        @endif
                        @error('selectedTime')
                            <p class="text-red-500 text-sm mt-3">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Step 4: Confirmation --}}
            <div x-show="step === 4" x-transition:enter="transition-all duration-300">
                <h2 class="text-2xl font-heading font-bold mb-2">Confirma tu Cita</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8">Revisa los detalles antes de confirmar.</p>
                <div class="space-y-4 mb-8">
                    <div class="flex items-center justify-between p-4 bg-cream dark:bg-secondary rounded-xl">
                        <span class="text-gray-500 dark:text-gray-400">Servicio</span>
                        <span class="font-semibold">{{ $serviceName ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-cream dark:bg-secondary rounded-xl">
                        <span class="text-gray-500 dark:text-gray-400">Barbero</span>
                        <span class="font-semibold">{{ $barberName ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-cream dark:bg-secondary rounded-xl">
                        <span class="text-gray-500 dark:text-gray-400">Fecha</span>
                        <span class="font-semibold">{{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') : '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-cream dark:bg-secondary rounded-xl">
                        <span class="text-gray-500 dark:text-gray-400">Hora</span>
                        <span class="font-semibold">{{ $selectedTime ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-primary/5 rounded-xl border border-primary/20">
                        <span class="font-heading font-bold text-lg">Total</span>
                        <span class="text-2xl font-heading font-bold text-primary">${{ number_format($servicePrice ?? 0, 0) }}</span>
                    </div>
                </div>

                @guest
                    <div class="space-y-4">
                        <h3 class="font-heading font-bold text-lg">Tus Datos</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Nombre</label>
                                <input type="text" wire:model="customerName" class="input-field" placeholder="Tu nombre">
                                @error('customerName') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Email</label>
                                <input type="email" wire:model="customerEmail" class="input-field" placeholder="correo@ejemplo.com">
                                @error('customerEmail') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Teléfono</label>
                            <input type="tel" wire:model="customerPhone" class="input-field" placeholder="+1 (555) 000-0000">
                            @error('customerPhone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-cream dark:bg-secondary rounded-xl">
                        <p class="text-sm text-gray-500">Reservando como:</p>
                        <p class="font-medium">{{ $customerName }} ({{ $customerEmail }})</p>
                    </div>
                @endguest
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex items-center justify-between mt-10 pt-6 border-t border-gray-100 dark:border-gray-700">
                <div>
                    <button x-show="step > 1" wire:click="back" class="flex items-center gap-2 text-gray-500 hover:text-primary transition-colors font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Anterior
                    </button>
                </div>
                <div>
                    <button x-show="step === 4" wire:click="submitBooking" wire:loading.attr="disabled" class="btn-primary">
                        <span wire:loading.remove>Confirmar Cita</span>
                        <span wire:loading>Procesando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Modal --}}
    <div x-show="$wire.showSuccessModal" x-cloak class="modal-overlay">
        <div class="modal-content p-8 text-center">
            <div class="w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mx-auto">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h2 class="text-2xl font-heading font-bold mt-6">¡Cita Confirmada!</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-3">Tu cita ha sido agendada exitosamente. Te esperamos.</p>
            <div class="mt-6 p-4 bg-cream dark:bg-secondary rounded-xl text-left space-y-2 text-sm">
                <p><span class="text-gray-500">Servicio:</span> <span class="font-medium">{{ $serviceName ?? '—' }}</span></p>
                <p><span class="text-gray-500">Barbero:</span> <span class="font-medium">{{ $barberName ?? '—' }}</span></p>
                <p><span class="text-gray-500">Fecha:</span> <span class="font-medium">{{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') : '' }}</span></p>
                <p><span class="text-gray-500">Hora:</span> <span class="font-medium">{{ $selectedTime }}</span></p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-8">
                <a href="{{ route('home') }}" class="btn-primary flex-1">Volver al Inicio</a>
                <a href="{{ route('booking') }}" wire:navigate class="btn-outline flex-1 text-center">Nueva Cita</a>
            </div>
        </div>
    </div>
</div>
