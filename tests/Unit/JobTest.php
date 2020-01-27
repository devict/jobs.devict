<?php

namespace Tests\Unit;

use App\Job;
use App\Notifications\JobCreated;
use App\Notifications\JobPublished;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_a_notifiation_when_created()
    {
        Notification::fake();

        $job = Job::create([
            'position' => 'test',
            'organization' => 'test',
            'url' => 'test',
            'email' => 'test',
        ]);

        Notification::assertSentTo(
            new AnonymousNotifiable,
            JobCreated::class,
            function ($notification, $channels, $notifiable) use ($job) {
                return $notification->job->is($job)
                    && in_array('mail', $channels)
                    && $notifiable->routes['mail'] === $job->email;
            }
        );
    }

    /** @test */
    public function it_can_be_published()
    {
        $job = Job::create([
            'position' => 'test',
            'organization' => 'test',
            'url' => 'test',
            'email' => 'christian@example.com',
        ]);

        $this->assertNull($job->published_at);

        $job->publish();

        $this->assertNotNull($job->fresh()->published_at);
    }

    /** @test */
    public function it_sends_a_notifiation_when_published()
    {
        Notification::fake();

        $job = Job::make([
            'position' => 'test',
            'organization' => 'test',
            'url' => 'test',
            'email' => 'test',
        ])->publish();

        Notification::assertSentTo(
            new AnonymousNotifiable,
            JobPublished::class,
            function ($notification, $channels, $notifiable) use ($job) {
                return $notification->job->is($job)
                    && in_array('mail', $channels)
                    && $notifiable->routes['mail'] === config('jobs.email');
            }
        );

        Notification::assertSentTo(
            new AnonymousNotifiable,
            JobPublished::class,
            function ($notification, $channels, $notifiable) use ($job) {
                return $notification->job->is($job)
                    && in_array('slack', $channels)
                    && $notifiable->routes['slack'] === config('jobs.slack_hook');
            }
        );
    }
}
