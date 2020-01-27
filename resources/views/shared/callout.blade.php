<div role="alert" class="flex items-start rounded font-semibold px-4 py-2 max-w-lg mx-auto {{ $class ?? '' }}">
    @isset($icon)
        <div class="flex-grow-0 mr-2" style="margin-top:2px;">{{ $icon }}</div>
    @endisset
    <div class="mr-auto">{{ $slot }}</div>
    @isset($close)
        <button
            type="button"
            class="ml-2 {{ $close }}"
            style="margin-top:2px;"
            aria-label="Close" onclick="this.parentNode.parentNode.removeChild(this.parentNode)"
        >
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20" fill="currentColor"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
        </button>
    @endisset
</div>
