<div class="flex flex-col justify-end" itemscope itemtype="https://schema.org/Place">

    <meta itemprop="name" content="{{ $page->locationName }}">

    @if($page->locationAddress)
        <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
            <meta itemprop="streetAddress" content="{{ $page->locationAddress }}">
        </div>
    @endif

    @if(isset($page->locationName))
        <span><strong class="opacity-75">Location:</strong> {{ $page->locationName }}</span>
    @endif

    @if(isset($page->locationAddress))
        <span><strong class="opacity-75">Address:</strong>
            <a href="https://maps.google.com/maps?q={{ urlencode($page->locationAddress) }}" target="_blank">
                <span>{{ $page->locationAddress }}</span>
            </a>
        </span>
    @endif

</div>
