<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-sans leading-normal text-gray-700 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
     <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700&display=swap" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('scripts')
</head>
<body class="min-h-screen flex flex-col">
    <header class="header-image relative text-center">
        <div class="relative py-16">
            <a href="{{ route('guest.jobs.index') }}" class="inline-block">
                <img src="{{ asset('svg/devict-logo.svg') }}" alt="devICT" class="h-6 block mb-2 mx-auto">
                <span class="text-4xl sm:text-5xl font-bold uppercase text-orange-500">
                    Job Board
                </span>
            </a>
        </div>
        <div class="absolute text-center w-full bottom-0 -mb-5">
            <a class="btn btn-primary" href="{{ route('guest.jobs.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20" fill="currentColor" class="inline-block mr-1"><path d="M11 9V5H9v4H5v2h4v4h2v-4h4V9h-4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20z"/></svg>
                Post a job
            </a>
        </div>
    </header>
    <main class="px-4 py-16 flex-1">
        <div class="max-w-lg mx-auto">
            @include('shared.flash')
            @yield('content')
        </div>
    </main>
    <footer class="footer-image text-center font-semibold text-orange-500">
        <span class="block text-center mb-2">A project by</span>
        <a href="https://devict.org">
            <img src="{{ asset('svg/devict-logo.svg') }}" alt="devICT" class="h-6 block mb-2 mx-auto">
        </a>
        <a href="https://github.com/devict/jobs.devict" class="hover:underline focus:underline">Contribute on GitHub</a>
    </footer>
</body>
</html>
