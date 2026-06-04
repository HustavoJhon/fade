@extends('layouts.public')

@section('title', 'Contacto')

@section('content')
    <section class="relative pt-32 pb-24 bg-secondary hero-overlay" style="background-image: url('{{ asset('images/contact-hero.jpg') }}');">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-heading font-bold text-cream">Contácta <span class="gold-text">con Nosotros</span></h1>
            <p class="mt-4 text-lg text-cream/60 max-w-2xl mx-auto">Estamos aquí para atenderte. Escríbenos, llámanos o visítanos.</p>
        </div>
    </section>

    <section class="py-24 bg-cream dark:bg-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <div>
                    <span class="text-primary font-semibold uppercase tracking-widest text-sm">Escríbenos</span>
                    <h2 class="text-4xl md:text-5xl font-heading font-bold mt-4">Envíanos un <span class="gold-text">Mensaje</span></h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-4">Déjanos tus datos y te contactaremos a la brevedad.</p>
                    <form method="POST" action="{{ route('contact.submit') }}" class="mt-8 space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium mb-2">Nombre Completo</label>
                                <input type="text" id="name" name="name" class="input-field" placeholder="Tu nombre" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium mb-2">Correo Electrónico</label>
                                <input type="email" id="email" name="email" class="input-field" placeholder="correo@ejemplo.com" required>
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium mb-2">Teléfono</label>
                            <input type="tel" id="phone" name="phone" class="input-field" placeholder="+1 (555) 000-0000">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium mb-2">Mensaje</label>
                            <textarea id="message" name="message" rows="5" class="input-field" placeholder="¿En qué podemos ayudarte?" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full sm:w-auto">Enviar Mensaje</button>
                    </form>
                </div>
                <div class="space-y-8">
                    <div>
                        <span class="text-primary font-semibold uppercase tracking-widest text-sm">Información</span>
                        <h2 class="text-4xl md:text-5xl font-heading font-bold mt-4">Datos de <span class="gold-text">Contacto</span></h2>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 p-5 card">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-heading font-bold text-lg">Dirección</h4>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">Av. Principal 123, Col. Centro<br>Ciudad, CP 12345</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-5 card">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-heading font-bold text-lg">Teléfono</h4>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">+1 (555) 123-4567</p>
                                <a href="https://wa.me/15551234567" target="_blank" class="text-primary hover:underline text-sm font-medium">WhatsApp: +1 (555) 123-4567</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-5 card">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-heading font-bold text-lg">Email</h4>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">info@fadebarberia.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <a href="https://wa.me/15551234567" target="_blank" class="flex-1 btn-primary text-center bg-green-600 hover:bg-green-700 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.294-.152-1.79-.864-2.07-.96-.28-.096-.484-.144-.688.144-.204.288-.78.96-.96 1.152-.176.192-.352.216-.648.072-.296-.144-1.252-.46-2.384-1.472-.88-.784-1.472-1.752-1.648-2.048-.176-.296-.02-.456.128-.6.136-.128.296-.336.444-.504.148-.168.2-.288.296-.48.096-.192.048-.36-.024-.504-.072-.144-.656-1.576-.896-2.152-.24-.576-.48-.48-.656-.48-.168-.008-.368-.008-.568-.008-.2 0-.52.072-.792.36-.272.288-1.04 1.016-1.04 2.48 0 1.464 1.064 2.88 1.216 3.080.152.2 2.096 3.208 5.088 4.496.712.312 1.264.496 1.696.632.72.224 1.376.192 1.896.12.58-.08 1.792-.736 2.048-1.448.256-.712.256-1.32.192-1.448-.064-.128-.24-.208-.536-.36zM12 2C6.48 2 2 6.48 2 12c0 2.168.72 4.16 1.912 5.768L2.94 21.06l3.292-1.008A9.914 9.914 0 0012 22c5.52 0 10-4.48 10-10S17.52 2 12 2z"/></svg>
                            WhatsApp
                        </a>
                        <a href="tel:+15551234567" class="flex-1 btn-outline text-center">Llamar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-24 bg-cream dark:bg-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl overflow-hidden shadow-lg h-96 bg-gray-200 dark:bg-dark-card flex items-center justify-center">
                <div class="text-center text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="text-lg font-medium">Google Maps Integración</p>
                    <p class="text-sm mt-1">Av. Principal 123, Col. Centro, Ciudad</p>
                </div>
            </div>
        </div>
    </section>
@endsection
