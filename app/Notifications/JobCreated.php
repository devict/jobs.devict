<?php

namespace App\Notifications;

use App\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobCreated extends Notification
{
    use Queueable;

    public $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("Thanks for adding your “{$this->job->position}” position to the devICT Job Board!")
            ->line('Use the link below to edit or remove your job post. **Keep in mind that anyone with this link can make changes to your post so be sure to keep it private.**')
            ->action('Edit job post', route('guest.jobs.edit', $this->job->token))
            ->line('Your job post will automatically expire after 30 days.');
    }

    public function toArray($notifiable)
    {
        return $this->job->toArray();
    }
}
