<div>
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold dark:text-white">Calendario</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Visualiza y gestiona las citas en el calendario.</p>
        </div>
    </div>

    <div class="card mb-6">
        <div class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-1">
                <label class="block text-xs font-medium mb-1">Barbero</label>
                <select wire:model.live="barberFilter" class="input-field !py-2 text-sm">
                    <option value="">Todos los barberos</option>
                    @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}">{{ $barber->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-xs font-medium mb-1">Estado</label>
                <select wire:model.live="statusFilter" class="input-field !py-2 text-sm">
                    <option value="">Todos los estados</option>
                    <option value="pending">Pendiente</option>
                    <option value="confirmed">Confirmada</option>
                    <option value="in_progress">En Progreso</option>
                    <option value="completed">Completada</option>
                    <option value="cancelled">Cancelada</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button wire:click="$set('view', 'dayGridMonth')" class="px-3 py-2 rounded-lg text-sm border {{ $view === 'dayGridMonth' ? 'bg-primary text-white border-primary' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50' }}">Mes</button>
                <button wire:click="$set('view', 'timeGridWeek')" class="px-3 py-2 rounded-lg text-sm border {{ $view === 'timeGridWeek' ? 'bg-primary text-white border-primary' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50' }}">Semana</button>
                <button wire:click="$set('view', 'timeGridDay')" class="px-3 py-2 rounded-lg text-sm border {{ $view === 'timeGridDay' ? 'bg-primary text-white border-primary' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50' }}">Día</button>
            </div>
        </div>
    </div>

    <div class="card p-4">
        <div id="calendar" wire:ignore
            data-events='{{ json_encode($events) }}'
            data-view="{{ $view }}"
            data-filter-barber="{{ $barberFilter }}"
            data-filter-status="{{ $statusFilter }}">
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('livewire:init', function () {
        const el = document.getElementById('calendar');
        if (!el) return;

        function initCalendar() {
            const events = JSON.parse(el.dataset.events || '[]');
            const view = el.dataset.view || 'dayGridMonth';

            if (window.calendarInstance) {
                window.calendarInstance.destroy();
            }

            const calendar = new FullCalendar.Calendar(el, {
                initialView: view,
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                events: events,
                eventClick: function (info) {
                    const props = info.event.extendedProps;
                    alert(
                        'Cliente: ' + props.customer + '\n' +
                        'Barbero: ' + props.barber + '\n' +
                        'Servicio: ' + props.service + '\n' +
                        'Estado: ' + props.status + '\n' +
                        'Precio: $' + (props.price || 0)
                    );
                },
                eventDrop: function (info) {
                    @this.updateEvent(
                        parseInt(info.event.id),
                        info.event.start.toISOString(),
                        info.event.end ? info.event.end.toISOString() : null
                    );
                },
                eventResize: function (info) {
                    @this.updateEvent(
                        parseInt(info.event.id),
                        info.event.start.toISOString(),
                        info.event.end ? info.event.end.toISOString() : null
                    );
                },
                editable: true,
                selectable: true,
                height: 'auto',
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
            });

            calendar.render();
            window.calendarInstance = calendar;
        }

        initCalendar();

        Livewire.on('filter-changed', () => {
            setTimeout(initCalendar, 100);
        });
    });
    </script>
    @endpush
</div>
