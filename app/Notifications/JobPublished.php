<?php

namespace App\Notifications;

use App\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class JobPublished extends Notification
{
    use Queueable;

    public $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("A “{$this->job->position}” position at {$this->job->organization} was posted to the devICT Job Board")
            ->action('Edit job post', URL::signedRoute('guest.jobs.edit', ['id' => $this->job->id]));
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->content('A job was posted!')
            ->attachment(function ($attachment) {
                $attachment->title(
                    "{$this->job->position} @ {$this->job->organization}",
                    route('guest.jobs.show', $this->job)
                );
            });
    }

    public function toArray($notifiable)
    {
        return $this->job->toArray();
    }
}
