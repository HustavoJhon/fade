@extends('layouts.customer')

@section('title', 'Mi Perfil')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-heading font-bold text-zinc-900 dark:text-white mb-8">Mi Perfil</h1>
        <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-6 sm:p-8">
            {{-- Avatar --}}
            <div class="flex flex-col sm:flex-row items-center gap-6 mb-8 pb-6 border-b border-zinc-100 dark:border-white/5">
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-white/5 flex items-center justify-center overflow-hidden">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-2xl font-heading font-bold text-zinc-500">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                </div>
                <div class="text-center sm:text-left">
                    <h2 class="text-lg font-heading font-bold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-zinc-500">{{ auth()->user()->email }}</p>
                </div>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-5">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Nombre Completo</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-4 h-10 rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-transparent text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Correo Electrónico</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full px-4 h-10 rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-transparent text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Teléfono</label>
                    <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full px-4 h-10 rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-transparent text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" placeholder="+1 (555) 000-0000">
                </div>
                <div class="border-t border-zinc-100 dark:border-white/5 pt-6">
                    <h3 class="font-heading font-bold text-zinc-900 dark:text-white mb-1">Cambiar Contraseña</h3>
                    <p class="text-sm text-zinc-500 mb-4">Deja en blanco si no deseas cambiar tu contraseña.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Nueva Contraseña</label>
                            <input type="password" name="password" class="w-full px-4 h-10 rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-transparent text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" placeholder="Mínimo 8 caracteres">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 h-10 rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-transparent text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" placeholder="Repite la contraseña">
                        </div>
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 text-sm font-medium rounded-lg hover:bg-zinc-800 dark:hover:bg-zinc-100 transition-colors">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection