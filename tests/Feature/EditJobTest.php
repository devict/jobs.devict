<?php

namespace Tests\Feature;

use App\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EditJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_view_the_edit_job_form()
    {
        $job = factory(Job::class)->create();

        $this->get(URL::signedRoute('guest.jobs.edit', $job))->assertStatus(200);
    }

    /** @test */
    public function jobs_that_do_not_exist_cannot_be_edited()
    {
        $this->get(URL::signedRoute('guest.jobs.edit', ['job' => 999]))->assertStatus(404);
        $this->put(URL::signedRoute('guest.jobs.update', ['job' => 999]))->assertStatus(404);
    }

    /** @test */
    public function guest_can_add_a_valid_job()
    {
        $job = factory(Job::class)->states('published')->create([
            'position' => 'Old position',
            'organization' => 'Old organization',
            'email' => 'old@example.com',
            'url' => 'https://oldurl.com',
            'description' => 'Old description',
        ]);

        $response = $this->put(URL::signedRoute('guest.jobs.update', $job), [
            'position' => 'Volunteer',
            'organization' => 'devICT',
            'email' => 'christian@example.com',
            'url' => 'https://devict.org',
            'description' => 'New description',
        ]);

        $response->assertRedirect(route('guest.jobs.index'));
        $response->assertSessionHasNoErrors();

        tap(Job::first(), function ($job) {
            $this->assertTrue($job->isPublished());

            $this->assertEquals('Volunteer', $job->position);
            $this->assertEquals('devICT', $job->organization);
            $this->assertEquals('christian@example.com', $job->email);
            $this->assertEquals('https://devict.org', $job->url);
            $this->assertEquals('New description', $job->description);
        });
    }

    /** @test */
    public function position_is_required()
    {
        $job = factory(Job::class)->states('published')->create($this->oldAttributes([
            'position' => 'Old position',
        ]));
        $response = $this->from(URL::signedRoute('guest.jobs.edit', $job))
            ->put(URL::signedRoute('guest.jobs.update', $job), $this->validParams([
                'position' => '',
            ]));

        $response->assertRedirect(URL::signedRoute('guest.jobs.edit', $job));
        $response->assertSessionHasErrors('position');
        tap($job->fresh(), function ($job) {
            $this->assertEquals('Old position', $job->position);
        });
    }

    /** @test */
    public function organization_is_required()
    {
        $job = factory(Job::class)->states('published')->create($this->oldAttributes([
            'organization' => 'Old organization',
        ]));
        $response = $this->from(URL::signedRoute('guest.jobs.edit', $job))
            ->put(URL::signedRoute('guest.jobs.update', $job), $this->validParams([
                'organization' => '',
            ]));

        $response->assertRedirect(URL::signedRoute('guest.jobs.edit', $job));
        $response->assertSessionHasErrors('organization');
        tap($job->fresh(), function ($job) {
            $this->assertEquals('Old organization', $job->organization);
        });
    }

    /** @test */
    public function url_is_optional()
    {
        $job = factory(Job::class)->states('published')->create($this->oldAttributes([
            'url' => 'https://oldsite.com',
        ]));
        $response = $this->from(URL::signedRoute('guest.jobs.edit', $job))
            ->put(URL::signedRoute('guest.jobs.update', $job), $this->validParams([
                'url' => '',
            ]));

        $response->assertRedirect(route('guest.jobs.index'));
        tap($job->fresh(), function ($job) {
            $this->assertNull($job->url);
        });
    }

    /** @test */
    public function url_must_be_a_valid_url()
    {
        $job = factory(Job::class)->states('published')->create($this->oldAttributes([
            'url' => 'https://oldsite.com',
        ]));
        $response = $this->from(URL::signedRoute('guest.jobs.edit', $job))
            ->put(URL::signedRoute('guest.jobs.update', $job), $this->validParams([
                'url' => 'not-a-url',
            ]));

        $response->assertRedirect(URL::signedRoute('guest.jobs.edit', $job));
        $response->assertSessionHasErrors('url');
        tap($job->fresh(), function ($job) {
            $this->assertEquals('https://oldsite.com', $job->url);
        });
    }

    /** @test */
    public function description_is_optional()
    {
        $job = factory(Job::class)->states('published')->create($this->oldAttributes([
            'description' => 'Old description',
        ]));
        $response = $this->from(URL::signedRoute('guest.jobs.edit', $job))
            ->put(URL::signedRoute('guest.jobs.update', $job), $this->validParams([
                'description' => '',
            ]));

        $response->assertRedirect(route('guest.jobs.index'));
        tap($job->fresh(), function ($job) {
            $this->assertNull($job->description);
        });
    }

    /** @test */
    public function email_is_required()
    {
        $job = factory(Job::class)->states('published')->create($this->oldAttributes([
            'email' => 'old@example.com',
        ]));
        $response = $this->from(URL::signedRoute('guest.jobs.edit', $job))
            ->put(URL::signedRoute('guest.jobs.update', $job), $this->validParams([
                'email' => '',
            ]));

        $response->assertRedirect(URL::signedRoute('guest.jobs.edit', $job));
        $response->assertSessionHasErrors('email');
        tap($job->fresh(), function ($job) {
            $this->assertEquals('old@example.com', $job->email);
        });
    }

    /** @test */
    public function email_must_be_a_valid_email()
    {
        $job = factory(Job::class)->states('published')->create($this->oldAttributes([
            'email' => 'old@example.com',
        ]));
        $response = $this->from(URL::signedRoute('guest.jobs.edit', $job))
            ->put(URL::signedRoute('guest.jobs.update', $job), $this->validParams([
                'email' => 'not-an-email',
            ]));

        $response->assertRedirect(URL::signedRoute('guest.jobs.edit', $job));
        $response->assertSessionHasErrors('email');
        tap($job->fresh(), function ($job) {
            $this->assertEquals('old@example.com', $job->email);
        });
    }

    private function oldAttributes($overrides = [])
    {
        return array_merge([
            'position' => 'Old position',
            'organization' => 'Old organization',
            'email' => 'old@example.com',
            'url' => 'https://oldurl.com',
            'description' => 'Old description',
        ], $overrides);
    }

    protected function validParams($overrides = [])
    {
        return array_merge([
            'position' => 'Volunteer',
            'organization' => 'devICT',
            'email' => 'christian@example.com',
            'url' => 'https://devict.org',
            'description' => 'New description',
        ], $overrides);
    }
}
