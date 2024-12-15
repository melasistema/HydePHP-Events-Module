@php
    // Load pagination config values
    $paginationConfig = config('hyde-events.pagination', [
       'page_size' => 10, // Default page size if not configured
    ]);
    // Check if the paginator is passed, otherwise initialize it
    $paginator = $page->matter('paginator') ?? new \Hyde\Support\Paginator(
       items: \Melasistema\HydeEventsModule\Pages\MarkdownEvent::getLatestEvents(),
       pageSize: $paginationConfig['page_size'],
       currentPageNumber: 1,  // Default to page 1 if not specified
       paginationRouteBasename: 'events'
    );
@endphp

@foreach($paginator->getItemsForPage() as $event)
    @include('hyde-events::components.event-excerpt', ['event' => $event])
@endforeach

@include('hyde::components.pagination-navigation')
