<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule\Framework\Features\Event\Models;

use Stringable;
use Hyde\Facades\Performer;
use Hyde\Facades\Config;
use Illuminate\Support\Collection;

use function strtolower;
use function is_string;

/**
 * This file is part of the Hyde Events Module package.
 * Object representation of an event performer.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 */
class EventPerformer implements Stringable
{
    /**
     * The name of the performer.
     * This is the key used to find performers in the config.
     */
    public readonly string $name;

    /**
     * The display role of the performer in the event.
     */
    public readonly ?string $role;

    /**
     * The performer's website URL.
     *
     * Could be a personal website, portfolio, or social media page.
     * Should be a fully qualified link, meaning it starts with http:// or https://.
     */
    public readonly ?string $website;

    /**
     * Construct a new Event Performer object.
     *
     * If your input is in the form of an array, you may want to use the `getOrCreate` method instead.
     *
     * @param  string  $name  The name of the performer.
     * @param  string|null  $role  The role of the performer.
     * @param  string|null  $website  The website or profile URL of the performer.
     */
    public function __construct(string $name, ?string $role = null, ?string $website = null)
    {
        $this->name = $name;
        $this->role = $role;
        $this->website = $website;
    }

    /**
     * Dynamically get or create a performer based on a name string or data array.
     *
     * @param  string|array{name?: string, role?: string, website?: string}  $data
     * @return static
     */
    public static function getOrCreate(string|array $data): static
    {
        if (is_string($data)) {
            return static::get($data);
        }

        return Performer::create(
            $data['name'] ?? 'Unnamed Performer',
            $data['role'] ?? null,
            $data['website'] ?? null
        );
    }

    /**
     * Get a Performer from the config, or create it if not found.
     *
     * @param  string  $name  The name of the performer.
     * @return static
     */
    public static function get(string $name): static
    {
        return static::all()->firstWhere('name', strtolower($name)) ?? Performer::create($name);
    }

    /**
     * Get all the defined Event Performer instances from the config.
     *
     * @return Collection<string, EventPerformer>
     */
    public static function all(): Collection
    {
        return (new Collection(Config::getArray('hyde.performers', [])))->mapWithKeys(function (self $performer): array {
            return [strtolower($performer->name) => $performer];
        });
    }

    /**
     * Convert the performer object to a string, returning the performer's name.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * Get the name of the performer.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
