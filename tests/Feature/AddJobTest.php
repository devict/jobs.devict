<?php

namespace Tests\Feature;

use App\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_view_the_add_job_form()
    {
        $this->get(route('guest.jobs.create'))->assertStatus(200);
    }

    /** @test */
    public function guest_can_add_a_valid_job()
    {
        $response = $this->post(route('guest.jobs.store'), [
            'position' => 'Volunteer',
            'organization' => 'devICT',
            'url' => 'https://devict.org',
            'description' => 'Test description',
            'email' => 'christian@example.com',
        ]);

        $response->assertRedirect(route('guest.jobs.index'));
        $response->assertSessionHasNoErrors();

        tap(Job::first(), function ($job) {
            $this->assertTrue($job->isPublished());

            $this->assertEquals('Volunteer', $job->position);
            $this->assertEquals('devICT', $job->organization);
            $this->assertEquals('https://devict.org', $job->url);
            $this->assertEquals('Test description', $job->description);
            $this->assertEquals('christian@example.com', $job->email);
        });
    }

    /** @test */
    public function position_is_required()
    {
        $response = $this->from(route('guest.jobs.create'))
            ->post(route('guest.jobs.store'), $this->validParams([
                'position' => '',
            ]));

        $response->assertRedirect(route('guest.jobs.create'));
        $response->assertSessionHasErrors('position');
        $this->assertEquals(0, Job::count());
    }

    /** @test */
    public function organization_is_required()
    {
        $response = $this->from(route('guest.jobs.create'))
            ->post(route('guest.jobs.store'), $this->validParams([
                'organization' => '',
            ]));

        $response->assertRedirect(route('guest.jobs.create'));
        $response->assertSessionHasErrors('organization');
        $this->assertEquals(0, Job::count());
    }

    /** @test */
    public function url_is_optional_when_theres_a_description()
    {
        $response = $this->from(route('guest.jobs.create'))
            ->post(route('guest.jobs.store'), $this->validParams([
                'description' => 'Test',
                'url' => '',
            ]));

        $response->assertRedirect(route('guest.jobs.index'));
        tap(Job::first(), function ($job) {
            $this->assertNull($job->url);
        });
    }

    /** @test */
    public function url_must_be_a_valid_url()
    {
        $response = $this->from(route('guest.jobs.create'))
            ->post(route('guest.jobs.store'), $this->validParams([
                'url' => 'not-a-url',
            ]));

        $response->assertRedirect(route('guest.jobs.create'));
        $response->assertSessionHasErrors('url');
        $this->assertEquals(0, Job::count());
    }

    /** @test */
    public function description_is_optional_when_theres_a_url()
    {
        $response = $this->from(route('guest.jobs.create'))
            ->post(route('guest.jobs.store'), $this->validParams([
                'url' => 'https://devict.org',
                'description' => '',
            ]));

        $response->assertRedirect(route('guest.jobs.index'));
        tap(Job::first(), function ($job) {
            $this->assertNull($job->description);
        });
    }

    /** @test */
    public function email_is_required()
    {
        $response = $this->from(route('guest.jobs.create'))
            ->post(route('guest.jobs.store'), $this->validParams([
                'email' => '',
            ]));

        $response->assertRedirect(route('guest.jobs.create'));
        $response->assertSessionHasErrors('email');
        $this->assertEquals(0, Job::count());
    }

    /** @test */
    public function email_must_be_a_valid_email()
    {
        $response = $this->from(route('guest.jobs.create'))
            ->post(route('guest.jobs.store'), $this->validParams([
                'email' => 'not-an-email',
            ]));

        $response->assertRedirect(route('guest.jobs.create'));
        $response->assertSessionHasErrors('email');
        $this->assertEquals(0, Job::count());
    }

    protected function validParams($overrides = [])
    {
        return array_merge([
            'position' => 'Volunteer',
            'organization' => 'devICT',
            'email' => 'christian@example.com',
        ], $overrides);
    }
}
