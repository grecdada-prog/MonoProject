<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportantActionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $subjectLine,
        protected string $messageLine
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->subjectLine)
            ->line($this->messageLine);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'subject' => $this->subjectLine,
            'message' => $this->messageLine,
        ];
    }
}
