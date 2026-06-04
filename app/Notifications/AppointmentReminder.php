<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Appointment $appointment
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Recordatorio de cita - Fade Barbershop')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Te recordamos que tienes una cita próximamente.')
            ->line('Servicio: ' . ($this->appointment->service?->name ?? 'N/A'))
            ->line('Barbero: ' . ($this->appointment->barber?->user?->name ?? 'N/A'))
            ->line('Fecha: ' . $this->appointment->start_time->format('d/m/Y'))
            ->line('Hora: ' . $this->appointment->start_time->format('H:i'))
            ->action('Ver detalles', route('customer.appointments'))
            ->line('Si no puedes asistir, por favor cancela con anticipación.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'appointment_reminder',
            'title' => 'Recordatorio de cita',
            'body' => 'Recuerda que tienes una cita para ' . ($this->appointment->service?->name ?? '') . ' el ' . $this->appointment->start_time->format('d/m/Y H:i') . '.',
            'appointment_id' => $this->appointment->id,
        ];
    }
}
