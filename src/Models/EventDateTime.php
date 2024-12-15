<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule\Models;

use DateTime;
use Exception;
use Stringable;

/**
 * This file is part of the Hyde Events Module package.
 * This class is responsible for parsing and formatting date-time strings.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 */
class EventDateTime implements Stringable
{
    /** Date format constants */
    final public const DATETIME_FORMAT = 'Y-m-d H:i:s';
    final public const SENTENCE_FORMAT = 'l, F j, Y \a\t g:i A';
    final public const SHORT_FORMAT = 'M j, Y, g:i A';

    /** The original date-time string. */
    public readonly string $string;

    /** The parsed DateTime object. */
    public readonly DateTime $dateTimeObject;

    /** The machine-readable datetime string. */
    public readonly string $datetime;

    /** The human-readable sentence string (full date and time). */
    public readonly string $sentence;

    /** Shorter version of the sentence string. */
    public readonly string $short;

    /** Separate date part (Y-m-d). */
    public readonly string $startDate;

    /** Separate time part (H:i). */
    public readonly string $startTime;

    /**
     * @throws Exception
     */
    public function __construct(string $string)
    {
        // Save the original string
        $this->string = $string;

        // Parse the full date and time from the provided string
        $this->dateTimeObject = new DateTime($string);

        // Format as machine-readable date-time
        $this->datetime = $this->dateTimeObject->format(self::DATETIME_FORMAT);

        // Human-readable date-time format
        $this->sentence = $this->dateTimeObject->format(self::SENTENCE_FORMAT);

        // Shorter human-readable format
        $this->short = $this->dateTimeObject->format(self::SHORT_FORMAT);

        // Separate the start date (Y-m-d)
        $this->startDate = $this->dateTimeObject->format('Y-m-d');

        // Separate the start time (H:i)
        $this->startTime = $this->dateTimeObject->format('H:i');
    }

    /**
     * Get the start date in machine-readable format (Y-m-d).
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * Get the start time in machine-readable format (H:i).
     */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * Convert the object to a string (use the short date-time format by default).
     */
    public function __toString(): string
    {
        return $this->short;
    }
}
