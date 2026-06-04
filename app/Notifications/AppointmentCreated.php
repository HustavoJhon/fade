<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentCreated extends Notification implements ShouldQueue
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
            ->subject('Cita creada - Fade Barbershop')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Tu cita ha sido creada exitosamente.')
            ->line('Servicio: ' . ($this->appointment->service?->name ?? 'N/A'))
            ->line('Barbero: ' . ($this->appointment->barber?->user?->name ?? 'N/A'))
            ->line('Fecha: ' . $this->appointment->start_time->format('d/m/Y'))
            ->line('Hora: ' . $this->appointment->start_time->format('H:i'))
            ->line('Precio: $' . number_format($this->appointment->total_price, 2))
            ->action('Ver mi cita', route('customer.appointments'))
            ->line('¡Gracias por preferirnos!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'appointment_created',
            'title' => 'Nueva cita creada',
            'body' => 'Tu cita para ' . ($this->appointment->service?->name ?? '') . ' ha sido creada.',
            'appointment_id' => $this->appointment->id,
        ];
    }
}
