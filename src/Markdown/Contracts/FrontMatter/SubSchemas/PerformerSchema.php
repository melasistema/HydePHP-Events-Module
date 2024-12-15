<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule\Markdown\Contracts\FrontMatter\SubSchemas;

use Melasistema\HydeEventsModule\Markdown\Contracts\FrontMatter\EventPostSchema;

/**
 * This file is part of the Hyde Events Module package.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 * @see \Melasistema\HydeEventsModule\Pages\MarkdownPost
 *
 */
interface PerformerSchema extends EventPostSchema
{
    public const PERFORMER_SCHEMA = [
        'name' => 'string',
        'role' => 'string',
        'website' => 'string',
    ];
}
