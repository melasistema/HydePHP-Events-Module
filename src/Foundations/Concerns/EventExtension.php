<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule\Foundations\Concerns;

use Hyde\Foundation\Concerns\HydeExtension;
use Hyde\Foundation\Kernel\FileCollection;
use Hyde\Foundation\Kernel\PageCollection;
use Hyde\Foundation\Kernel\RouteCollection;
use Hyde\Pages\Concerns\HydePage;

/**
 * This file is part of the Hyde Events Module package.
 * This class is responsible for extending Hyde with custom event functionality
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 */
class EventExtension extends HydeExtension
{
    /**
     * Register the custom page class.
     *
     * @return array<class-string<HydePage>>
     */
    public static function getPageClasses(): array
    {
        return [
            \Melasistema\HydeEventsModule\Pages\MarkdownEvent::class,
        ];
    }

    /**
     * Discover event files during the file discovery process.
     */
    public function discoverFiles(FileCollection $collection): void
    {
        // Add custom logic to discover files, if necessary.
        // Example: $collection->add($pathToEventFile);
    }

    /**
     * Discover event pages during the page discovery process.
     */
    public function discoverPages(PageCollection $collection): void
    {
        // Add custom logic to discover pages.
        // Example: $collection->add(new EventPage($parameters));
    }

    /**
     * Discover event routes during the route discovery process.
     */
    public function discoverRoutes(RouteCollection $collection): void
    {
        // Add custom logic to generate routes for your event pages.
        // Example:
        // foreach ($collection->getPages(EventPage::class) as $page) {
        //     $collection->addRoute(new Route($page));
        // }
    }
}
