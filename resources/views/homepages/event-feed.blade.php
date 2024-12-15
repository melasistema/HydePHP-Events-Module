{{-- Event Page Feed --}}
@php($title = 'Events')
@extends('hyde::layouts.app')
@section('content')

    <main id="content" class="mx-auto max-w-7xl py-12 px-8">

        <header class="lg:mb-12 xl:mb-16">
            <h1 class="text-3xl text-left leading-10 tracking-tight font-extrabold sm:leading-none mb-8 md:mb-12 md:text-4xl md:text-center lg:text-5xl text-gray-700 dark:text-gray-200">
                Events
            </h1>
        </header>

        <div id="event-feed" class="max-w-3xl mx-auto">
            @include('hyde-events::components.event-post-feed')
        </div>

    </main>

@endsection
