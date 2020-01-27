@extends('layouts.base')
@section('content')
    <form method="post" action="{{ route('guest.jobs.update', $job->token) }}">
        @csrf
        @method('put')
        @include('guest.jobs._fields')
        <div class="flex justify-between items-center mt-6">
            <button class="btn btn-primary">Update</button>
            <button
                type="button"
                class="font-semibold text-gray-500 underline hover:no-underline hover:text-red-600 focus:no-underline focus:text-red-600"
                onclick="document.getElementById('delete-form').querySelector('button').click()"
            >Remove</button>
        </div>
    </form>
    <form
        id="delete-form"
        method="post"
        action="{{ route('guest.jobs.destroy', $job->token) }}"
        onsubmit="return confirm('Are you sure you want to remove this job?')"
        style="display:none;"
    >
        @csrf
        @method('delete')
        <button>Remove</button>
    </form>
@endsection
