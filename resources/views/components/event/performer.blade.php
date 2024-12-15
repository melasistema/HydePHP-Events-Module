<!-- Performer Section -->
<address itemprop="performer" itemscope itemtype="https://schema.org/Person" aria-label="The event performer" style="display: inline; font-style: normal;">
    @if($page->performer->website)
        <strong class="opacity-75">Performer:</strong>
        <a class="text-small" href="{{ $page->performer->website }}" rel="performer" itemprop="url" aria-label="The event performer website" target="_blank">
            <span itemprop="name" aria-label="The performer's name" title="{{ $page->performer->name ? '@' . urlencode($page->performer->name) : '' }}">{{ $page->performer->name }}</span>
        </a>
        @elseif($page->performer->name)
        <strong class="opacity-75">Performer:</strong>
        <span itemprop="name">{{ $page->performer->name }}</span>
    @endif
</address>
