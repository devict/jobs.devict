@extends('layouts.base')
@section('content')
    <ul class="-mx-4">
        @forelse($jobs as $job)
            <li class="flex mb-2 p-4 relative border-b sm:border-b-0 last:border-b-0 hover:bg-blue-100 group sm:rounded-lg">
                <div class="w-full sm:pr-16">
                    <h2 class="font-bold text-lg">{{ $job->position }}</h2>
                    <div>{{ $job->organization }}</div>
                    <a
                        href="{{ route('guest.jobs.show', $job) }}"
                        class="relative z-10 text-gray-500 hover:underline focus:underline"
                    >
                        <time datetime="{{ $job->published_at->toRfc3339String() }}" class="text-sm">
                            Posted {{ $job->published_at->diffForHumans() }}
                        </time>
                    </a>
                </div>
                @if($job->url)
                    <a
                        href="{{ $job->url }}"
                        target="_blank"
                        class="opacity-0 text-sm font-bold text-orange-500 uppercase absolute inset-0 flex items-center justify-end p-4 sm:group-hover:opacity-100 sm:focus:opacity-100"
                    >Apply</a>
                @else
                    <a
                        href="{{ route('guest.jobs.show', $job) }}"
                        class="opacity-0 text-sm font-bold text-orange-500 uppercase absolute inset-0 flex items-center justify-end p-4 sm:group-hover:opacity-100 sm:focus:opacity-100"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="24" height="24" fill="currentColor"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
                    </a>
                @endif
            </li>
        @empty
            <li class="text-lg font-light text-center">
                <strong class="font-bold">No job openings posted.</strong> The software development industry is 100% employed at the moment.
            </li>
        @endforelse
    </ul>
@endsection
