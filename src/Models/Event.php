<?php

namespace Melasistema\HydeEventsModule\Models;

use Hyde\Markdown\Models\Markdown;

/**
 * This file is part of the Hyde Events Module package.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 */

class Event extends Markdown
{
    public static string $sourceDirectory = '_events';

    public function getType(): string
    {
        return 'event';
    }

    public static function getSourceDirectory(): string
    {
        return static::$sourceDirectory;
    }
}