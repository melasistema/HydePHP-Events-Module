{{-- Single Event Page --}}
@extends('hyde::layouts.app')
@section('content')

    <main id="content" class="mx-auto max-w-7xl py-16 px-8">
        @include('hyde-events::components.event.article')
    </main>

@endsection
