<time itemprop="startDate" datetime="{{ $page->startDateTime->datetime }}" title="{{ $page->startDateTime->sentence }}"></time>

<div class="flex items-center justify-end">
    <!-- Display day of the week -->
    <div class="text-lg font-extrabold text-gray-700 dark:text-gray-200">
        {{ $page->startDateTime->dateTimeObject->format('l') }}
    </div>
    <!-- Display day of the month -->
    <div class="text-4xl p-4 font-extrabold text-gray-700 dark:text-gray-200">
        {{ $page->startDateTime->dateTimeObject->format('d') }}
    </div>
    <!-- Display month and year -->
    <div class="opacity-75">
        {{ $page->startDateTime->dateTimeObject->format('F Y') }}
    </div>
</div>

<!-- Adding the meta tag for doorTime -->
<div class="flex items-center justify-end">
    <meta itemprop="doorTime" content="{{ $page->startDateTime->dateTimeObject->format('Y-m-d\TH:i:sP') }}">

    <span class="block">
        <strong class="opacity-75">⏰</strong>
        <!-- Display door opening time in a readable format -->
        <time itemprop="doorTime" datetime="{{ $page->startDateTime->dateTimeObject->format('Y-m-d\TH:i:sP') }}">
            {{ $page->startDateTime->dateTimeObject->format('g:i A') }}
        </time>
    </span>
</div>

