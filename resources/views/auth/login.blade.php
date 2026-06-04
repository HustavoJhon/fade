@extends('layouts.public')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-32 px-4 bg-cream dark:bg-secondary">
        <div class="w-full max-w-md">
            <div class="card p-8 md:p-10">
                <div class="text-center mb-8">
                    <span class="text-3xl font-heading font-bold gold-text">FADE</span>
                    <h2 class="text-2xl font-heading font-bold mt-4">Iniciar Sesión</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Accede a tu cuenta para gestionar tus citas.</p>
                </div>
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Correo Electrónico</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="input-field" placeholder="correo@ejemplo.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium mb-2">Contraseña</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="input-field" placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>
                    <button type="submit" class="btn-primary w-full">Iniciar Sesión</button>
                </form>
                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">Regístrate</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
