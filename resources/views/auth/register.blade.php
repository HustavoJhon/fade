@extends('layouts.public')

@section('title', 'Crear Cuenta')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-32 px-4 bg-cream dark:bg-secondary">
        <div class="w-full max-w-md">
            <div class="card p-8 md:p-10">
                <div class="text-center mb-8">
                    <span class="text-3xl font-heading font-bold gold-text">FADE</span>
                    <h2 class="text-2xl font-heading font-bold mt-4">Crear Cuenta</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Regístrate para agendar y gestionar tus citas.</p>
                </div>
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">Nombre Completo</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="input-field" placeholder="Tu nombre">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Correo Electrónico</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="input-field" placeholder="correo@ejemplo.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium mb-2">Teléfono</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-gray-300 dark:border-white/10 bg-gray-100 dark:bg-zinc-800 text-gray-500 dark:text-gray-400 text-sm font-semibold tracking-wide select-none">+51</span>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="!rounded-l-none input-field" placeholder="999 999 999" required>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Código +51 Perú · 9 dígitos</p>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium mb-2">Contraseña</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="input-field" placeholder="Mínimo 8 caracteres">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium mb-2">Confirmar Contraseña</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="input-field" placeholder="Repite la contraseña">
                    </div>
                    <div>
                        <label class="flex items-start gap-2">
                            <input type="checkbox" name="terms" required class="mt-0.5 rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Acepto los <a href="#" class="text-primary hover:underline">Términos y Condiciones</a> y la <a href="#" class="text-primary hover:underline">Política de Privacidad</a></span>
                        </label>
                        @error('terms')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn-primary w-full">Crear Cuenta</button>
                </form>
                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Inicia Sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
