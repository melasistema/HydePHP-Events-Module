<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule;

use Hyde\Hyde;
use Hyde\Pages\InMemoryPage;
use Hyde\Support\Paginator;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Melasistema\HydeEventsModule\Commands\PublishEventHomepageCommand;
use Melasistema\HydeEventsModule\Commands\MakeEventCommand;
use Melasistema\HydeEventsModule\Foundations\Concerns\EventExtension;
use Melasistema\HydeEventsModule\Pages\MarkdownEvent;

/**
 * This package extends the functionality of HydePHP.
 * HydePHP is an elegant static site generator by Caen De Silva.
 *
 * @link https://github.com/hydephp/hyde
 * This file is part of the Hyde Events Module package.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola <info@melasistema.com>
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 */

class HydeEventsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        // Register commands
        $this->commands([
            MakeEventCommand::class,
            PublishEventHomepageCommand::class,
        ]);

        // Merge configuration or bind services here.
        $this->mergeConfigFrom(__DIR__ . '/../config/hyde-events-module.php', 'hyde-events');

        $this->app->make(\Hyde\Foundation\HydeKernel::class)
            ->registerExtension(EventExtension::class);

    }

    /**
     * Bootstrap the service
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPagination();

        // Publish a configuration file
        $this->publishes([
            __DIR__ . '/../config/hyde-events-module.php' => config_path('hyde-events.php'),
        ], 'hyde-events-config');

        // Register the views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'hyde-events');

        // Publish the views to the resources/views/vendor directory
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/hyde-events'),
        ], 'hyde-events-views');

        // Publish the custom Tailwind config to the root of the project
        $this->publishes([
            __DIR__ . '/../tailwind-events.config.js' => base_path('tailwind-events.config.js'),
        ], 'tailwind-events-config');
    }

    /**
     * Register pagination for the events
     *
     * @return void
     */
    protected function registerPagination(): void
    {
        Hyde::kernel()->booted(function () {
            // Load pagination config
            $paginationConfig = config('hyde-events.pagination', [
                'page_size' => 4, // Page size from config
            ]);

            // Create the paginator for the events
            $paginator = new Paginator(
                items: MarkdownEvent::getLatestEvents(),
                pageSize: $paginationConfig['page_size'],
                currentPageNumber: 1,
                paginationRouteBasename: 'events'
            );

            // Loop through total pages and create routes for them
            foreach (range(1, $paginator->totalPages()) as $pageNumber) {
                $paginator->setCurrentPage($pageNumber);

                // Create a page for each pagination
                $listingPage = new InMemoryPage(
                    identifier: "events/page-{$pageNumber}",
                    matter: [
                        'title' => "Events - Page {$pageNumber}",
                        'paginator' => clone $paginator,  // Clone to keep it specific to this page
                        'events' => $paginator->getItemsForPage(),
                    ],
                    view: 'events'
                );

                // Register the page and route
                Hyde::kernel()->pages()->addPage($listingPage);
                Hyde::kernel()->routes()->addRoute($listingPage->getRoute());
            }
        });
    }
}
