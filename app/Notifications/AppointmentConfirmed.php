<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentConfirmed extends Notification implements ShouldQueue
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
            ->subject('Cita confirmada - Fade Barbershop')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Tu cita ha sido confirmada.')
            ->line('Servicio: ' . ($this->appointment->service?->name ?? 'N/A'))
            ->line('Barbero: ' . ($this->appointment->barber?->user?->name ?? 'N/A'))
            ->line('Fecha: ' . $this->appointment->start_time->format('d/m/Y'))
            ->line('Hora: ' . $this->appointment->start_time->format('H:i'))
            ->action('Ver mi cita', route('customer.appointments'))
            ->line('¡Te esperamos!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'appointment_confirmed',
            'title' => 'Cita confirmada',
            'body' => 'Tu cita para ' . ($this->appointment->service?->name ?? '') . ' ha sido confirmada.',
            'appointment_id' => $this->appointment->id,
        ];
    }
}
