<label class="block">
    @isset($label)
        <span class="form-label">{!! $label !!}</span>
    @endisset
    @isset($required)
        <span class="align-top text-sm text-gray-500">*</span>
    @endif
    @isset($description)
        <span class="form-description">{!! $description !!}</span>
    @endif
    @error($errorKey = trim(str_replace(['[', ']', '..'], '.', $name), '.'))
        <span class="form-error">{{ $message }}</span>
    @enderror
    {{ $slot }}
</label>
