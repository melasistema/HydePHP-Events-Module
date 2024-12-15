<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule\Markdown\Contracts\FrontMatter;

use Hyde\Markdown\Contracts\FrontMatter\SubSchemas\FeaturedImageSchema;
use Melasistema\HydeEventsModule\Markdown\Contracts\FrontMatter\SubSchemas\PerformerSchema;

/**
 * This file is part of the Hyde Events Module package.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 * @see \Melasistema\HydeEventsModule\Pages\MarkdownEvent
 *
 */
interface EventPostSchema extends PageEventSchema
{
    public const EVENT_POST_SCHEMA = [
        'title' => 'string',
        'description' => 'string',
        'category' => 'string',
        'date' => 'string',

        // Event specific fields
        'startDateTime' => 'string',
        'locationName' => 'string',
        'locationAddress' => 'string',
        'link' => 'string',

        'performer' => ['string', PerformerSchema::PERFORMER_SCHEMA],
        'image' => ['string', FeaturedImageSchema::FEATURED_IMAGE_SCHEMA],
    ];
}
