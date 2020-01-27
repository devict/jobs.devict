@if ($success = session('success'))
    @component('shared.callout', [
        'class' => 'bg-green-100 text-green-600 mb-4',
        'close' => 'text-green-300 hover:text-green-600 focus:text-green-600'
    ])
        @slot('icon')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20" fill="currentColor"><path d="M11 0h1v3l3 7v8a2 2 0 0 1-2 2H5c-1.1 0-2.31-.84-2.7-1.88L0 12v-2a2 2 0 0 1 2-2h7V2a2 2 0 0 1 2-2zm6 10h3v10h-3V10z"/></svg>
        @endslot
        {{ $success }}
    @endcomponent
@endif
@if ($errorCount = $errors->count())
    @component('shared.callout', [
        'class' => 'bg-red-100 text-red-600 mb-4',
        'close' => 'text-red-300 hover:text-red-600 focus:text-red-600'
    ])
        @slot('icon')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20" fill="currentColor"><path d="M11 20a2 2 0 0 1-2-2v-6H2a2 2 0 0 1-2-2V8l2.3-6.12A3.11 3.11 0 0 1 5 0h8a2 2 0 0 1 2 2v8l-3 7v3h-1zm6-10V0h3v10h-3z"/></svg>
        @endslot
        There {{ $errorCount > 1 ? "are {$errorCount} errors" : 'is one error' }} on the page.
    @endcomponent
@endif
