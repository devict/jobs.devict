<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Job;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Job::class, function (Faker $faker) {
    return [
        'position' => $faker->sentence,
        'organization' => $faker->sentence,
        'url' => $faker->url,
        'email' => $faker->email,
    ];
});

$factory->state(Job::class, 'published', function ($faker) {
    return [
        'published_at' => Carbon::parse('-1 week'),
    ];
});
