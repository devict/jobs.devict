<?php

namespace Tests\Feature;

use App\Job;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewPublishedJobsList extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_view_published_jobs()
    {
        $unpublished = factory(Job::class)->create([
            'position' => 'Unpublished job',
        ]);
        $publishedA = factory(Job::class)->create([
            'position' => 'Published job 1',
            'published_at' => Carbon::parse('5 days ago'),
        ]);
        $publishedB = factory(Job::class)->create([
            'position' => 'Published job 2',
            'published_at' => Carbon::parse('1 day ago'),
        ]);

        $response = $this->get(route('guest.jobs.index'));

        $response->assertDontSee($unpublished->position);
        $response->assertSeeInOrder([
            $publishedB->position,
            $publishedA->position,
        ]);
    }

    /** @test */
    public function guest_can_view_a_published_job()
    {
        $job = factory(Job::class)->create([
            'position' => 'Developer',
            'organization' => 'Organization',
            'url' => 'https://devict.org',
            'description' => 'Test description',
            'published_at' => Carbon::today(),
        ]);

        $response = $this->get(route('guest.jobs.show', $job));

        $response->assertStatus(200);
        $response->assertSee('Developer');
        $response->assertSee('Organization');
        $response->assertSee('https://devict.org');
        $response->assertSee('Test description');
        $response->assertSee(Carbon::today()->toRfc3339String());
    }

    /** @test */
    public function guest_cannot_view_jobs_older_than_30_days()
    {
        $oldJob = factory(Job::class)->create([
            'published_at' => Carbon::today()->subDays(30),
        ]);
        $newJob = factory(Job::class)->create([
            'published_at' => Carbon::today(),
        ]);

        $this->get(route('guest.jobs.index'))->assertDontSee($oldJob->position);
        $this->get(route('guest.jobs.show', $oldJob))->assertNotFound();
        $this->get(route('guest.jobs.index'))->assertSee($newJob->position);
        $this->get(route('guest.jobs.show', $newJob))->assertOk();
    }
}
