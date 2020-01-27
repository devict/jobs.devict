@component('shared.field', [
    'name' => 'position',
    'label' => 'Position',
    'required' => true,
])
    <input name="position" class="form-input mb-3"  value="{{ old('position', $job->position) }}" required>
@endcomponent

@component('shared.field', [
    'name' => 'organization',
    'label' => 'Organization',
    'required' => true,
])
    <input name="organization" class="form-input mb-3" value="{{ old('organization', $job->organization) }}" required>
@endcomponent

@component('shared.field', [
    'name' => 'url',
    'label' => 'URL',
])
    <input type="url" name="url" class="form-input mb-3" value="{{ old('url', $job->url) }}">
@endcomponent

@component('shared.field', [
    'name' => 'description',
    'label' => 'Description',
    'description' => 'Provide a description below if no URL is available',
])
    <textarea name="description" rows="4" class="form-textarea mb-3">{{ old('description', $job->description) }}</textarea>
@endcomponent

@component('shared.field', [
    'name' => 'email',
    'label' => 'Your Email',
    'description' => "We'll send you a link to edit this job posting.",
    'required' => true,
])
    <input type="email" name="email" class="form-input" value="{{ old('email', $job->email) }}" required>
@endcomponent

