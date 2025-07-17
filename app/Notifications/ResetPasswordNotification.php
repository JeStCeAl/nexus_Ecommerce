<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = 'nexusapp://reset/reset-password?' . http_build_query([
            'token' => $this->token,
            'email' => $notifiable->email
        ]);
        return (new MailMessage)
            ->subject('Restablecer Contraseña')
            ->line('Recibes este correo porque solicitaste un restablecimiento de contraseña.')
            ->action('Restablecer Contraseña', $url)
            ->line('Si no lo solicitaste, ignora este mensaje.');
    }
}
