@extends('layouts.public')

@section('title', 'Inicio')

@section('content')
    {{-- Hero Section --}}
    <section class="relative min-h-screen flex items-center hero-overlay bg-cover bg-center" style="background-image: url('{{ asset('images/hero-bg.jpg') }}');">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-heading font-bold text-cream leading-tight animate-fade-in">
                    Donde el <span class="gold-text">Estilo</span><br>se Encuentra con la<br><span class="gold-text">Tradición</span>
                </h1>
                <p class="mt-6 text-lg md:text-xl text-cream/80 max-w-xl animate-fade-in stagger-1">
                    Experimenta el arte del grooming premium. Cortes modernos, barbas impecables y una experiencia que trasciende lo convencional.
                </p>
                <div class="mt-10 flex flex-col sm:flex-row gap-4 animate-fade-in stagger-2">
                    <a href="{{ route('booking') }}" class="btn-primary text-lg text-center">
                        Reservar Cita
                    </a>
                    <a href="{{ route('services') }}" class="btn-outline text-center border-cream/30 text-cream hover:bg-cream hover:text-secondary">
                        Ver Servicios
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 animate-bounce">
            <svg class="w-6 h-6 text-cream/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
        </div>
    </section>

    {{-- Stats Bar --}}
    <section class="bg-secondary dark:bg-dark relative -mt-20 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="gold-gradient rounded-2xl shadow-2xl p-8 md:p-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl md:text-5xl font-heading font-bold text-white">10+</div>
                        <div class="text-white/80 mt-2 font-medium">Años de Experiencia</div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-5xl font-heading font-bold text-white">5K+</div>
                        <div class="text-white/80 mt-2 font-medium">Clientes Felices</div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-5xl font-heading font-bold text-white">15K+</div>
                        <div class="text-white/80 mt-2 font-medium">Servicios Realizados</div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-5xl font-heading font-bold text-white">6</div>
                        <div class="text-white/80 mt-2 font-medium">Barberos Expertos</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services Section --}}
    <section class="py-24 bg-cream dark:bg-secondary" id="servicios">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary font-semibold uppercase tracking-widest text-sm">Nuestros Servicios</span>
                <h2 class="text-4xl md:text-5xl font-heading font-bold mt-4">Cortes que <span class="gold-text">Hablan</span></h2>
                <p class="text-gray-600 dark:text-gray-400 mt-4 leading-relaxed">Desde el clásico hasta lo vanguardista, cada servicio está diseñado para realzar tu estilo.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="card group hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mb-5 group-hover:bg-primary group-hover:text-white transition-all">
                        <svg class="w-8 h-8 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold">Corte Clásico</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">Corte tradicional con tijera y máquina, incluye lavado y styling.</p>
                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <span class="text-2xl font-heading font-bold text-primary">$25</span>
                        <span class="text-sm text-gray-400">45 min</span>
                    </div>
                </div>
                <div class="card group hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mb-5 group-hover:bg-primary group-hover:text-white transition-all">
                        <svg class="w-8 h-8 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 14.121m0 0A3 3 0 105.88 19.12m8.24-8.24a3 3 0 002.12 5.122m-5.122-5.12a3 3 0 10-5.122 5.12"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold">Afeitado Clásico</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">Afeitado tradicional con navaja, toalla caliente y productos premium.</p>
                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <span class="text-2xl font-heading font-bold text-primary">$30</span>
                        <span class="text-sm text-gray-400">40 min</span>
                    </div>
                </div>
                <div class="card group hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mb-5 group-hover:bg-primary group-hover:text-white transition-all">
                        <svg class="w-8 h-8 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold">Corte + Barba</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">Combo completo: corte personalizado + arreglo de barba con toalla caliente.</p>
                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <span class="text-2xl font-heading font-bold text-primary">$45</span>
                        <span class="text-sm text-gray-400">75 min</span>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('services') }}" class="btn-outline">Ver Todos los Servicios</a>
            </div>
        </div>
    </section>

    {{-- Barbers Section --}}
    <section class="py-24 bg-secondary dark:bg-dark" id="barberos">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary font-semibold uppercase tracking-widest text-sm">Nuestro Equipo</span>
                <h2 class="text-4xl md:text-5xl font-heading font-bold text-cream mt-4">Artistas del <span class="gold-text">Estilo</span></h2>
                <p class="text-cream/60 mt-4 leading-relaxed">Conoce a los maestros barberos que transformarán tu look.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group text-center">
                    <div class="relative overflow-hidden rounded-2xl mb-5 aspect-[3/4] bg-primary/10">
                        <img src="{{ asset('images/barber-1.jpg') }}" alt="Barber 1" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <div class="text-left text-cream">
                                <p class="text-sm">5+ años de experiencia</p>
                                <p class="text-primary font-semibold">Especialista en Fades</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-cream">Alejandro Martínez</h3>
                    <p class="text-primary font-medium mt-1">Barbero Senior</p>
                </div>
                <div class="group text-center">
                    <div class="relative overflow-hidden rounded-2xl mb-5 aspect-[3/4] bg-primary/10">
                        <img src="{{ asset('images/barber-2.jpg') }}" alt="Barber 2" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <div class="text-left text-cream">
                                <p class="text-sm">8+ años de experiencia</p>
                                <p class="text-primary font-semibold">Especialista en Barbas</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-cream">Carlos Ramírez</h3>
                    <p class="text-primary font-medium mt-1">Maestro Barbero</p>
                </div>
                <div class="group text-center">
                    <div class="relative overflow-hidden rounded-2xl mb-5 aspect-[3/4] bg-primary/10">
                        <img src="{{ asset('images/barber-3.jpg') }}" alt="Barber 3" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <div class="text-left text-cream">
                                <p class="text-sm">3+ años de experiencia</p>
                                <p class="text-primary font-semibold">Especialista en Degradados</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-cream">Miguel Torres</h3>
                    <p class="text-primary font-medium mt-1">Barbero Junior</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="py-24 bg-cream dark:bg-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary font-semibold uppercase tracking-widest text-sm">Testimonios</span>
                <h2 class="text-4xl md:text-5xl font-heading font-bold mt-4">Lo que Dicen <span class="gold-text">Nuestros Clientes</span></h2>
            </div>
            <div x-data="{ active: 0 }" class="relative max-w-4xl mx-auto">
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500" :style="`transform: translateX(-${active * 100}%)`">
                        <div class="min-w-full px-4">
                            <div class="card text-center p-10">
                                <div class="w-16 h-16 rounded-full bg-primary/10 mx-auto flex items-center justify-center">
                                    <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                                </div>
                                <p class="text-lg text-gray-600 dark:text-gray-400 mt-6 leading-relaxed italic">"La mejor barbería de la ciudad. Alejandro hizo un trabajo increíble con mi fade. Definitivamente volveré."</p>
                                <div class="mt-6">
                                    <div class="flex justify-center gap-1 text-primary">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    </div>
                                    <p class="font-semibold mt-4">Juan Pérez</p>
                                    <p class="text-sm text-gray-500">Cliente frecuente</p>
                                </div>
                            </div>
                        </div>
                        <div class="min-w-full px-4">
                            <div class="card text-center p-10">
                                <div class="w-16 h-16 rounded-full bg-primary/10 mx-auto flex items-center justify-center">
                                    <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                                </div>
                                <p class="text-lg text-gray-600 dark:text-gray-400 mt-6 leading-relaxed italic">"Excelente atención y ambiente. El servicio de afeitado clásico es una experiencia que todos deberían probar."</p>
                                <div class="mt-6">
                                    <div class="flex justify-center gap-1 text-primary">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    </div>
                                    <p class="font-semibold mt-4">Carlos Mendoza</p>
                                    <p class="text-sm text-gray-500">Cliente frecuente</p>
                                </div>
                            </div>
                        </div>
                        <div class="min-w-full px-4">
                            <div class="card text-center p-10">
                                <div class="w-16 h-16 rounded-full bg-primary/10 mx-auto flex items-center justify-center">
                                    <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                                </div>
                                <p class="text-lg text-gray-600 dark:text-gray-400 mt-6 leading-relaxed italic">"Desde que entré por primera vez, supe que había encontrado mi barbería. El ambiente, la música, el servicio... todo es perfecto."</p>
                                <div class="mt-6">
                                    <div class="flex justify-center gap-1 text-primary">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    </div>
                                    <p class="font-semibold mt-4">Roberto Díaz</p>
                                    <p class="text-sm text-gray-500">Cliente frecuente</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center gap-3 mt-8">
                    <button @click="active = 0" :class="active === 0 ? 'bg-primary' : 'bg-gray-300 dark:bg-gray-600'" class="w-3 h-3 rounded-full transition-all"></button>
                    <button @click="active = 1" :class="active === 1 ? 'bg-primary' : 'bg-gray-300 dark:bg-gray-600'" class="w-3 h-3 rounded-full transition-all"></button>
                    <button @click="active = 2" :class="active === 2 ? 'bg-primary' : 'bg-gray-300 dark:bg-gray-600'" class="w-3 h-3 rounded-full transition-all"></button>
                </div>
            </div>
        </div>
    </section>

    {{-- Hours Section --}}
    <section class="py-24 bg-secondary dark:bg-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-primary font-semibold uppercase tracking-widest text-sm">Horarios</span>
                    <h2 class="text-4xl md:text-5xl font-heading font-bold text-cream mt-4">Ven a <span class="gold-text">Visitarnos</span></h2>
                    <p class="text-cream/60 mt-4 leading-relaxed">Estamos abiertos de lunes a sábado para brindarte la mejor experiencia.</p>
                    <div class="mt-8 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl">
                            <span class="text-cream font-medium">Lunes - Viernes</span>
                            <span class="text-primary font-semibold">9:00 AM - 7:00 PM</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl">
                            <span class="text-cream font-medium">Sábado</span>
                            <span class="text-primary font-semibold">9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl">
                            <span class="text-cream font-medium">Domingo</span>
                            <span class="text-red-400 font-semibold">Cerrado</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-square rounded-2xl overflow-hidden bg-primary/10">
                        <div class="w-full h-full flex items-center justify-center text-primary/30">
                            <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Section --}}
    <section class="py-24 bg-cream dark:bg-secondary" id="contacto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary font-semibold uppercase tracking-widest text-sm">Contacto</span>
                <h2 class="text-4xl md:text-5xl font-heading font-bold mt-4">Estamos <span class="gold-text">Aquí</span></h2>
                <p class="text-gray-600 dark:text-gray-400 mt-4 leading-relaxed">Visítanos o contáctanos para cualquier consulta.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <div class="card text-center group hover:-translate-y-2">
                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mx-auto group-hover:bg-primary transition-all">
                        <svg class="w-7 h-7 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-heading font-bold mt-4">Dirección</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Av. Principal 123, Col. Centro<br>Ciudad, CP 12345</p>
                </div>
                <div class="card text-center group hover:-translate-y-2">
                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mx-auto group-hover:bg-primary transition-all">
                        <svg class="w-7 h-7 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <h3 class="text-lg font-heading font-bold mt-4">Teléfono</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">+1 (555) 123-4567</p>
                </div>
                <div class="card text-center group hover:-translate-y-2">
                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mx-auto group-hover:bg-primary transition-all">
                        <svg class="w-7 h-7 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-heading font-bold mt-4">Email</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">info@fadebarberia.com</p>
                </div>
            </div>
            <div class="rounded-2xl overflow-hidden shadow-lg h-80 bg-gray-200 dark:bg-dark-card flex items-center justify-center">
                <div class="text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p>Google Maps Integración</p>
                </div>
            </div>
        </div>
    </section>
@endsection
