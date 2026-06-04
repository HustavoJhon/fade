<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeCustomer extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('¡Bienvenido a Fade Barbershop!')
            ->greeting('¡Bienvenido ' . $this->user->name . '!')
            ->line('Tu cuenta ha sido creada exitosamente.')
            ->line('Ya puedes agendar tus citas y disfrutar de nuestros servicios.')
            ->action('Agendar una cita', route('booking'))
            ->line('¡Gracias por unirte a Fade Barbershop!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'welcome',
            'title' => '¡Bienvenido a Fade Barbershop!',
            'body' => 'Tu cuenta ha sido creada exitosamente. Ya puedes agendar tus citas.',
            'user_id' => $this->user->id,
        ];
    }
}
