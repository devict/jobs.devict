@extends('layouts.base')
@section('content')
    <h2 class="font-bold text-lg">{{ $job->position }}</h2>
    <div class="mb-6">{{ $job->organization }}</div>
    <div class="mb-6">{!! $job->formatted_description !!}</div>
    @if ($job->url)
        <div class="mb-6">
            <a href="{{ $job->url }}" target="_blank" class="btn btn-primary">
                Apply
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20" fill="currentColor" class="inline-block ml-1"><path d="M0 3c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm2 2v12h16V5H2zm8 3l4 5H6l4-5z"/></svg>
            </a>
        </div>
    @endif
    <a
        href="{{ route('guest.jobs.show', $job) }}"
        class="relative z-10 text-gray-500 hover:underline focus:underline"
    >
        <time datetime="{{ $job->published_at->toRfc3339String() }}" class="text-sm">
            Posted {{ $job->published_at->diffForHumans() }}
        </time>
    </a>
@endsection
