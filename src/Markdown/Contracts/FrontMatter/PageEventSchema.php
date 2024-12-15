<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule\Markdown\Contracts\FrontMatter;

use Hyde\Markdown\Contracts\FrontMatter\SubSchemas\NavigationSchema;
/**
 * This file is part of the Hyde Events Module package.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 * @see \Hyde\Pages\Concerns\HydePage
 *
 */
interface PageEventSchema extends FrontMatterEventSchema
{
    public const PAGE_EVENT_SCHEMA = [
        'title' => 'string',
        'canonicalUrl' => 'string', // While not present in the page data, it is supported as a front matter key for the accessor data source.
        'navigation' => NavigationSchema::NAVIGATION_SCHEMA,
    ];
}
