<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorCodeNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $code
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre code de connexion SmartStock')
            ->line('Voici votre code de vérification pour accéder à SmartStock :')
            ->line("Code : {$this->code}")
            ->line('Ce code expire dans 10 minutes.')
            ->line('Si vous n’êtes pas à l’origine de cette tentative, merci de contacter un administrateur.');
    }
}
