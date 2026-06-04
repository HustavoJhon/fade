@extends('layouts.public')

@section('title', 'Nosotros')

@section('content')
    <section class="relative pt-32 pb-24 bg-secondary hero-overlay" style="background-image: url('{{ asset('images/about-hero.jpg') }}');">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-heading font-bold text-cream">Nuestra <span class="gold-text">Historia</span></h1>
            <p class="mt-4 text-lg text-cream/60 max-w-2xl mx-auto">Conoce más sobre FADE, nuestra pasión y el equipo que hace posible cada experiencia.</p>
        </div>
    </section>

    <section class="py-24 bg-cream dark:bg-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="text-primary font-semibold uppercase tracking-widest text-sm">Nuestra Historia</span>
                    <h2 class="text-4xl md:text-5xl font-heading font-bold mt-4">Más que una Barbería,<br><span class="gold-text">Una Tradición</span></h2>
                    <div class="mt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                        <p>FADE nació en 2014 de la pasión compartida de dos amigos por el arte de la barbería. Lo que comenzó como un pequeño espacio en el centro de la ciudad, hoy es un referente del grooming masculino.</p>
                        <p>Creemos que cada corte cuenta una historia. Cada cliente que se sienta en nuestras sillas es único, y nuestro compromiso es realzar su estilo personal con técnicas tradicionales y modernas.</p>
                        <p>Nuestros barberos son artistas dedicados que combinan años de experiencia con las últimas tendencias para ofrecer resultados excepcionales.</p>
                    </div>
                    <div class="flex gap-8 mt-8">
                        <div>
                            <div class="text-3xl font-heading font-bold text-primary">10+</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Años</div>
                        </div>
                        <div>
                            <div class="text-3xl font-heading font-bold text-primary">5000+</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Clientes</div>
                        </div>
                        <div>
                            <div class="text-3xl font-heading font-bold text-primary">6</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Barberos</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/5] rounded-2xl overflow-hidden bg-primary/10">
                        <img src="{{ asset('images/about-story.jpg') }}" alt="FADE Barbería" class="w-full h-full object-cover" loading="lazy">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-secondary p-6 rounded-2xl shadow-xl hidden md:block">
                        <div class="text-4xl font-heading font-bold gold-text">10+</div>
                        <div class="text-cream/80 text-sm">Años de excelencia</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-secondary dark:bg-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card bg-white/5 border border-primary/10 hover:border-primary/30">
                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-2xl font-heading font-bold text-cream">Misión</h3>
                    <p class="text-cream/60 mt-4 leading-relaxed">Proporcionar servicios de barbería de la más alta calidad en un ambiente único que combine tradición y modernidad, asegurando que cada cliente se sienta y luzca mejor.</p>
                </div>
                <div class="card bg-white/5 border border-primary/10 hover:border-primary/30">
                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <h3 class="text-2xl font-heading font-bold text-cream">Visión</h3>
                    <p class="text-cream/60 mt-4 leading-relaxed">Ser la barbería líder en la región, reconocida por nuestra excelencia, innovación y el impacto positivo en la comunidad, expandiendo nuestra cultura de estilo y cuidado personal.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-cream dark:bg-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary font-semibold uppercase tracking-widest text-sm">Nuestro Equipo</span>
                <h2 class="text-4xl md:text-5xl font-heading font-bold mt-4">Conoce a los <span class="gold-text">Maestros</span></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group text-center">
                    <div class="relative overflow-hidden rounded-2xl mb-5 aspect-[3/4] bg-primary/10">
                        <img src="{{ asset('images/barber-1.jpg') }}" alt="Alejandro Martínez" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <div class="text-left text-cream">
                                <p class="text-sm text-primary font-semibold">Especialista en Fades</p>
                                <p class="text-xs text-cream/60 mt-1">5+ años de experiencia</p>
                                <div class="flex gap-2 mt-3">
                                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-all"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-all"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-heading font-bold">Alejandro Martínez</h3>
                    <p class="text-primary font-medium mt-1">Barbero Senior</p>
                </div>
                <div class="group text-center">
                    <div class="relative overflow-hidden rounded-2xl mb-5 aspect-[3/4] bg-primary/10">
                        <img src="{{ asset('images/barber-2.jpg') }}" alt="Carlos Ramírez" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <div class="text-left text-cream">
                                <p class="text-sm text-primary font-semibold">Especialista en Barbas</p>
                                <p class="text-xs text-cream/60 mt-1">8+ años de experiencia</p>
                                <div class="flex gap-2 mt-3">
                                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-all"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-all"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-heading font-bold">Carlos Ramírez</h3>
                    <p class="text-primary font-medium mt-1">Maestro Barbero</p>
                </div>
                <div class="group text-center">
                    <div class="relative overflow-hidden rounded-2xl mb-5 aspect-[3/4] bg-primary/10">
                        <img src="{{ asset('images/barber-3.jpg') }}" alt="Miguel Torres" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <div class="text-left text-cream">
                                <p class="text-sm text-primary font-semibold">Especialista en Degradados</p>
                                <p class="text-xs text-cream/60 mt-1">3+ años de experiencia</p>
                                <div class="flex gap-2 mt-3">
                                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-all"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-all"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-heading font-bold">Miguel Torres</h3>
                    <p class="text-primary font-medium mt-1">Barbero Junior</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-secondary dark:bg-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary font-semibold uppercase tracking-widest text-sm">Línea de Tiempo</span>
                <h2 class="text-4xl md:text-5xl font-heading font-bold text-cream mt-4">Nuestra <span class="gold-text">Trayectoria</span></h2>
            </div>
            <div class="relative">
                <div class="absolute left-1/2 -translate-x-px h-full w-0.5 bg-primary/20 hidden md:block"></div>
                <div class="space-y-12">
                    <div class="relative flex flex-col md:flex-row items-center gap-8 md:gap-16">
                        <div class="md:w-1/2 md:text-right">
                            <div class="card bg-white/5 border border-primary/10">
                                <span class="text-primary font-heading font-bold text-2xl">2014</span>
                                <h4 class="text-lg font-heading font-bold text-cream mt-2">El Comienzo</h4>
                                <p class="text-cream/60 text-sm mt-2">Apertura del primer local en el centro de la ciudad con solo 2 sillas.</p>
                            </div>
                        </div>
                        <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-primary border-4 border-secondary"></div>
                        <div class="md:w-1/2"></div>
                    </div>
                    <div class="relative flex flex-col md:flex-row items-center gap-8 md:gap-16">
                        <div class="md:w-1/2"></div>
                        <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-primary border-4 border-dark"></div>
                        <div class="md:w-1/2 md:text-left">
                            <div class="card bg-white/5 border border-primary/10">
                                <span class="text-primary font-heading font-bold text-2xl">2017</span>
                                <h4 class="text-lg font-heading font-bold text-cream mt-2">Expansión</h4>
                                <p class="text-cream/60 text-sm mt-2">Triplicamos nuestro espacio y sumamos 3 nuevos barberos al equipo.</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative flex flex-col md:flex-row items-center gap-8 md:gap-16">
                        <div class="md:w-1/2 md:text-right">
                            <div class="card bg-white/5 border border-primary/10">
                                <span class="text-primary font-heading font-bold text-2xl">2020</span>
                                <h4 class="text-lg font-heading font-bold text-cream mt-2">Innovación</h4>
                                <p class="text-cream/60 text-sm mt-2">Implementamos sistema de reservas en línea y protocolos de higiene avanzados.</p>
                            </div>
                        </div>
                        <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-primary border-4 border-secondary"></div>
                        <div class="md:w-1/2"></div>
                    </div>
                    <div class="relative flex flex-col md:flex-row items-center gap-8 md:gap-16">
                        <div class="md:w-1/2"></div>
                        <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-primary border-4 border-dark"></div>
                        <div class="md:w-1/2 md:text-left">
                            <div class="card bg-white/5 border border-primary/10">
                                <span class="text-primary font-heading font-bold text-2xl">2024</span>
                                <h4 class="text-lg font-heading font-bold text-cream mt-2">Actualidad</h4>
                                <p class="text-cream/60 text-sm mt-2">Referentes en grooming masculino con más de 15,000 servicios realizados.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
