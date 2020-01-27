@extends('layouts.base')
@section('content')
    <form method="post" action="{{ route('guest.jobs.store') }}">
        @csrf
        @include('guest.jobs._fields')
        <button class="btn btn-primary mt-6">Publish</button>
    </form>
@endsection
