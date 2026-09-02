<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailChanged extends Notification
{
    use Queueable;

    public function __construct(
        public User $user,
        public string $originalEmail,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your email address has been changed')
            ->line('Heads up, your email has been updated.')
            ->line('If you did not make this change, please get in touch with support.');
    }
}
