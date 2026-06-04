<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-heading font-bold text-zinc-900 dark:text-white">Dashboard</h1>
            <p class="text-sm text-zinc-500 mt-1">{{ now()->format('l, d F Y') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.appointments') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 text-sm font-medium rounded-lg hover:bg-zinc-800 dark:hover:bg-zinc-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Nueva cita
            </a>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Citas Hoy</span>
                <span class="w-8 h-8 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $todayAppointments }}</div>
            <div class="flex items-center gap-2 mt-1.5">
                <span class="text-xs text-zinc-500">{{ $todayCompleted }} completadas</span>
                @if($todayAppointments > 0)
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">{{ round(($todayCompleted / max($todayAppointments, 1)) * 100) }}%</span>
                @endif
            </div>
        </div>
        <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Ingresos Hoy</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-zinc-900 dark:text-white">${{ number_format($todayRevenue, 0) }}</div>
            <div class="flex items-center gap-2 mt-1.5">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">+12.5%</span>
                <span class="text-xs text-zinc-500">vs ayer</span>
            </div>
        </div>
        <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Clientes</span>
                <span class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalCustomers }}</div>
            <div class="flex items-center gap-2 mt-1.5">
                <span class="text-xs text-zinc-500">{{ $newCustomers }} nuevos este mes</span>
            </div>
        </div>
        <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Ingresos del Mes</span>
                <span class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-zinc-900 dark:text-white">${{ number_format($monthRevenue, 0) }}</div>
            <div class="mt-2 w-full h-1.5 bg-zinc-100 dark:bg-white/10 rounded-full overflow-hidden">
                <div class="h-full bg-purple-500 rounded-full" style="width: {{ min(100, ($monthRevenue / max($monthGoal, 1)) * 100) }}%"></div>
            </div>
        </div>
    </div>

    {{-- Middle section: Schedule + Chart --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Today's schedule --}}
        <div class="lg:col-span-2 bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200 dark:border-white/5">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Citas de hoy</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">{{ now()->format('d/m/Y') }}</p>
                </div>
                <a href="{{ route('admin.appointments') }}" class="text-xs text-zinc-500 hover:text-zinc-900 dark:hover:text-white font-medium transition-colors">Ver todas</a>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-white/5">
                @php
                    $todayAppts = $recentAppointments->filter(fn($a) => \Carbon\Carbon::parse($a->start_time)->isToday())->sortBy('start_time');
                @endphp
                @forelse($todayAppts->take(8) as $appt)
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                    <div class="text-center flex-shrink-0 w-14">
                        <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ \Carbon\Carbon::parse($appt->start_time)->format('H:i') }}</div>
                        <div class="text-[10px] text-zinc-400">{{ \Carbon\Carbon::parse($appt->start_time)->format('h:i A') }}</div>
                    </div>
                    <div class="w-0.5 h-10 rounded-full flex-shrink-0 {{ $appt->status === 'completed' ? 'bg-emerald-400' : ($appt->status === 'cancelled' ? 'bg-red-400' : 'bg-primary') }}"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">{{ $appt->customer?->user?->name ?? $appt->customer_name ?? 'Cliente' }}</p>
                        <p class="text-xs text-zinc-500 truncate">{{ $appt->service?->name }} {{ $appt->barber?->user?->name ? '• '.$appt->barber->user->name : '' }}</p>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="badge-{{ $appt->status }} text-xs">{{ __(ucfirst($appt->status)) }}</span>
                        <span class="text-sm font-medium text-zinc-900 dark:text-white">${{ number_format($appt->total_price, 0) }}</span>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center">
                    <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <p class="text-sm text-zinc-500">No hay citas programadas para hoy</p>
                    <a href="{{ route('admin.appointments') }}" class="inline-flex items-center gap-1 text-xs text-primary font-medium mt-2 hover:text-primary-dark">Agendar una cita →</a>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Right sidebar --}}
        <div class="space-y-6">
            {{-- Quick actions --}}
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-4">Acciones rápidas</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.appointments') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-zinc-50 dark:bg-white/5 hover:bg-primary/10 dark:hover:bg-primary/20 hover:border-primary/30 dark:hover:border-primary/50 border border-transparent transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-primary dark:text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Nueva cita</span>
                    </a>
                    <a href="{{ route('admin.customers') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-zinc-50 dark:bg-white/5 hover:bg-blue-50 dark:hover:bg-blue-900/10 hover:border-blue-200 dark:hover:border-blue-800 border border-transparent transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Nuevo cliente</span>
                    </a>
                    <a href="{{ route('admin.calendar') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-zinc-50 dark:bg-white/5 hover:bg-purple-50 dark:hover:bg-purple-900/10 hover:border-purple-200 dark:hover:border-purple-800 border border-transparent transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        </div>
                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Calendario</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-zinc-50 dark:bg-white/5 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 hover:border-emerald-200 dark:hover:border-emerald-800 border border-transparent transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3H19.5v6"/></svg>
                        </div>
                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Reportes</span>
                    </a>
                </div>
            </div>

            {{-- Stats summary --}}
            <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-5">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-4">Resumen del negocio</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500">Barberos activos</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $totalBarbers }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500">Servicios</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $totalServices }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500">Citas este mes</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $monthAppointments }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500">Pendientes</span>
                        <span class="text-sm font-semibold text-primary dark:text-primary-light">{{ $pendingAppointments }}</span>
                    </div>
                    <div class="pt-3 border-t border-zinc-100 dark:border-white/5">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">Utilidad del mes</span>
                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">${{ number_format(max(0, $monthRevenue - $monthExpenses), 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom: revenue chart + recent appointments --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Revenue chart --}}
        <div class="lg:col-span-2 bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Ingresos (30 días)</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">Evolución de ingresos diarios</p>
                </div>
                <div class="flex items-center gap-2 bg-zinc-100 dark:bg-white/5 rounded-lg p-0.5">
                    <button class="px-3 py-1 text-xs font-medium rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white shadow-sm">7d</button>
                    <button class="px-3 py-1 text-xs font-medium rounded-md text-zinc-500 hover:text-zinc-900 dark:hover:text-white">30d</button>
                </div>
            </div>
            <div class="h-72">
                <canvas id="revenueChart" data-chart='{{ json_encode(['labels' => $revenueLabels, 'values' => $revenueValues]) }}'></canvas>
            </div>
        </div>

        {{-- Recent appointments --}}
        <div class="bg-white dark:bg-secondary rounded-xl border border-zinc-200 dark:border-white/5">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-white/5">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Actividad reciente</h3>
                <p class="text-xs text-zinc-500 mt-0.5">Últimas citas registradas</p>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-white/5">
                @forelse($recentAppointments->take(6) as $appt)
                <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-white/5 flex items-center justify-center flex-shrink-0 text-xs font-bold text-zinc-500">
                        {{ substr($appt->customer?->user?->name ?? $appt->customer_name ?? '?', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">{{ $appt->customer?->user?->name ?? $appt->customer_name ?? 'Cliente' }}</p>
                        <p class="text-xs text-zinc-500 truncate">{{ $appt->service?->name ?? '—' }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <span class="badge-{{ $appt->status }} text-xs">{{ __(ucfirst($appt->status)) }}</span>
                        <p class="text-[10px] text-zinc-400 mt-0.5">{{ \Carbon\Carbon::parse($appt->start_time)->format('d/m H:i') }}</p>
                    </div>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-sm text-zinc-500">Sin actividad reciente</div>
                @endforelse
            </div>
        </div>
    </div>
</div>