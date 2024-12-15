<article aria-label="Event" id="{{ $page->identifier }}" itemscope itemtype="https://schema.org/Event" @class(['event-article mx-auto', config('markdown.prose_classes', 'prose dark:prose-invert'), 'torchlight-enabled' => Features::hasTorchlight()])>
    <meta itemprop="identifier" content="{{ $page->identifier }}">
    @if($page->getCanonicalUrl() !== null)
        <meta itemprop="url" content="{{ $page->getCanonicalUrl() }}">
    @endif

    <header aria-label="Header section" role="doc-pageheader">
        <h1 itemprop="headline" class="mb-4">{{ $page->title }}</h1>
        @includeWhen(isset($page->performer), 'hyde-events::components.event.performer')

        <div id="byline" aria-label="About the event" role="doc-introduction">
            @includeWhen(isset($page->category), 'hyde-events::components.event.category')
            @includeWhen(isset($page->startDateTime), 'hyde-events::components.event.date')
            @includeWhen(isset($page->link), 'hyde-events::components.event.link')
            @includeWhen(isset($page->locationName), 'hyde-events::components.event.location')
        </div>
    </header>

    @includeWhen(isset($page->image), 'hyde-events::components.event.image')

    <div aria-label="Article body" itemprop="articleBody">{{ $content }}</div>

    <span class="sr-only">End of Event</span>
</article>
