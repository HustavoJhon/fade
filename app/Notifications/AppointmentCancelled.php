<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentCancelled extends Notification implements ShouldQueue
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
            ->subject('Cita cancelada - Fade Barbershop')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Tu cita ha sido cancelada.')
            ->line('Servicio: ' . ($this->appointment->service?->name ?? 'N/A'))
            ->line('Barbero: ' . ($this->appointment->barber?->user?->name ?? 'N/A'))
            ->line('Fecha original: ' . $this->appointment->start_time->format('d/m/Y H:i'))
            ->lineIf($this->appointment->cancellation_reason, 'Motivo: ' . $this->appointment->cancellation_reason)
            ->action('Agendar nueva cita', route('booking'))
            ->line('Si tienes dudas, contáctanos.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'appointment_cancelled',
            'title' => 'Cita cancelada',
            'body' => 'Tu cita para ' . ($this->appointment->service?->name ?? '') . ' ha sido cancelada.',
            'appointment_id' => $this->appointment->id,
        ];
    }
}
