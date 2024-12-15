@php /** @var \Melasistema\HydeEventsModule\Pages\MarkdownEvent $event */ @endphp
<article class="mt-4 mb-8 max-w-full" itemscope itemtype="https://schema.org/Event">
    <meta itemprop="identifier" content="{{ $event->identifier }}">
    @if(Hyde::hasSiteUrl())
        <meta itemprop="url" content="{{ Hyde::url('events/' . $event->identifier) }}">
    @endif

    <!-- Event Description -->
    @if($event->data('description'))
        <meta itemprop="description" content="{{ $event->data('description') }}">
    @endif

    <!-- Event Start Date -->
    @if(isset($event->startDateTime))
        <meta itemprop="startDate" content="{{ $event->startDateTime->dateTimeObject->format('Y-m-d\TH:i:sP') }}">
    @endif

    <!-- Event Door Time -->
    @if(isset($event->startTime))
        <meta itemprop="doorTime" content="{{ $event->startTime->dateTimeObject->format('Y-m-d\TH:i:sP') }}">
    @endif

    <!-- Event Performer -->
    @if(!empty($event->performer->name))
        <meta itemprop="performer" itemscope itemtype="https://schema.org/Person">
        <meta itemprop="name" content="{{ $event->performer->name }}">
        @if(!empty($event->performer->website))
            <meta itemprop="url" content="{{ $event->performer->website }}">
                @endif
            </meta>
        @endif

    <!-- Event Location -->
    @if(isset($event->locationName))
        <div itemprop="location" itemscope itemtype="https://schema.org/Place">
            <meta itemprop="name" content="{{ $event->locationName }}">
            @if($event->locationAddress)
                <meta itemprop="address" content="{{ $event->locationAddress }}">
            @endif
        </div>
    @endif

    <!-- Event Image (Optional) -->
    @if(isset($event->image))
        <meta itemprop="image" content="{{ $event->image->getSource() }}">
    @endif

    <!-- Article Wrapper -->
    <div class="article-wrapper max-w-screen-lg mx-auto">
        <div class="flex-inline md:flex items-stretch gap-4 rounded-lg">
            <!-- Left Column: Calendar Icon -->
            <div class="flex flex-col items-center justify-center rounded-md p-4 min-w-1/5">
                @if($event->startDateTime)
                    <div class="text-lg font-extrabold text-gray-700 dark:text-gray-200">
                        {{ $event->startDateTime->dateTimeObject->format('l') }}
                    </div>
                    <div class="text-4xl p-4 font-extrabold text-gray-700 dark:text-gray-200">
                        {{ $event->startDateTime->dateTimeObject->format('d') }}
                    </div>
                    <div class="opacity-75">
                        {{ $event->startDateTime->dateTimeObject->format('F Y') }}
                    </div>
                @endif
            </div>

            <!-- Right Column: Event Details -->
            <div class="flex flex-col rounded-md w-full">
                <header>
                    <a href="{{ $event->getRoute() }}" class="block w-fit">
                        <h2 itemprop="name" class="text-2xl font-bold text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white transition-colors duration-75">
                            <!-- Event Name -->
                            {{ $event->data('title') ?? $event->title }}
                        </h2>
                    </a>

                    @if(!empty($event->performer->name))
                        <address itemprop="performer" itemscope itemtype="https://schema.org/Person" aria-label="The event performer" style="display: inline; font-style: normal;">
                            <strong class="opacity-75">Performer:</strong>
                            @if(!empty($event->performer->website))
                                <a class="text-small text-indigo-500 hover:underline font-medium" href="{{ $event->performer->website }}" rel="performer" itemprop="url" aria-label="The event performer website" target="_blank">
                                    <span itemprop="name" aria-label="The performer's name" title="{{ $event->performer->name ? '@' . urlencode($event->performer->name) : '' }}">{{ $event->performer->name }}</span>
                                </a>
                            @else
                                <span itemprop="name">{{ $event->performer->name }}</span>
                            @endif
                        </address>
                    @endif
                </header>

                <footer>
                    @if($event->data('description'))
                        <section role="doc-abstract" aria-label="Excerpt" class="my-2">
                            <p class="leading-relaxed my-1"><span itemprop="description">{{ $event->data('description') }}</span></p>
                        </section>
                    @endif
                    <!-- Additional Information -->
                    @if(isset($event->startDateTime))
                        <p class="text-2xs leading-relaxed my-1"><time itemprop="doorTime" datetime="{{ $event->startDateTime->dateTimeObject->format('Y-m-d\TH:i:sP') }}">⏰ {{ $event->startDateTime->dateTimeObject->format('g:i A') }}</time></p>
                    @endif

                    @if(isset($event->locationName))
                        <p class="text-2xs leading-relaxed my-1">📍{{ $event->locationName }} @if(isset($event->locationAddress))
                                <span itemprop="address"> - {{ $event->locationAddress }}</span></p>
                            @endif
                        </p>
                    @endif


                    <a href="{{ $event->getRoute() }}" class="text-indigo-500 hover:underline font-medium">
                        More details
                    </a>

                </footer>
            </div>
        </div>
    </div>
</article>
