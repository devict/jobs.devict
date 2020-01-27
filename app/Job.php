<?php

namespace App;

use App\Notifications\JobCreated;
use App\Notifications\JobPublished;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class Job extends Model
{
    protected $guarded = [];

    protected $dates = ['published_at'];

    public static function create(array $attributes = [])
    {
        $job = self::query()->create($attributes + [
            'token' => hash_hmac('sha256', Str::random(40), config('app.key')),
        ]);

        return tap($job, function ($job) {
            Notification::route('mail', $job->email)->notify(new JobCreated($job));
        });
    }

    public static function make(array $attributes = [])
    {
        return self::query()->make($attributes + [
            'token' => hash_hmac('sha256', Str::random(40), config('app.key')),
        ]);
    }

    public static function findByToken($token)
    {
        return self::where('token', $token)->firstOrFail();
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeLastPublished($query)
    {
        return $query->orderByDesc('published_at');
    }

    public function publish()
    {
        $job = tap($this)->update(['published_at' => $this->freshTimestamp()]);

        return tap($job, function ($job) {
            Notification::route('mail', config('jobs.email'))
                ->route('slack', config('jobs.slack_hook'))
                ->notify(new JobPublished($job));
        });
    }

    public function isUnpublished()
    {
        return is_null($this->published_at);
    }

    public function isPublished()
    {
        return ! $this->isUnpublished();
    }

    public function scopeRecent($query)
    {
        return $query->where('published_at', '>=', Carbon::now()->subDays(30));
    }

    public function isRecent()
    {
        return $this->published_at->greaterThanOrEqualTo(Carbon::now()->subDays(30));
    }

    public function isOld()
    {
        return ! $this->isRecent();
    }
}
