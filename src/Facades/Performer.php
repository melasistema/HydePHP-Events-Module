<?php

declare(strict_types=1);

namespace Hyde\Facades;

use Melasistema\HydeEventsModule\Framework\Features\Event\Models\EventPerformer;
use Illuminate\Support\Collection;

/**
 * Allows you to easily add pre-defined performers for your events.
 *
 * @see \Melasistema\HydeEventsModule\Framework\Features\Event\Models\EventPerformer
 */
class Performer
{
    /**
     * Construct a new Event Performer. For Hyde to discover this performer,
     * you must call this method from your hyde.php config file.
     *
     * @see https://hydephp.com/docs/1.x/customization.html#performers
     *
     * @param  string  $name  The name of the performer.
     * @param  string|null  $role  The role of the performer in the event (e.g., "Keynote Speaker").
     * @param  string|null  $website  The website or personal profile of the performer.
     */
    public static function create(string $name, ?string $role = null, ?string $website = null): EventPerformer
    {
        return new EventPerformer($name, $role, $website);
    }

    /**
     * Get an Event Performer instance from the config. If no performer matching the username is found,
     * a new Event Performer instance will be created with just the name supplied to the method.
     *
     * @param  string  $name  The identifier for the performer.
     * @return \Melasistema\HydeEventsModule\Framework\Features\Event\Models\EventPerformer
     */
    public static function get(string $name): EventPerformer
    {
        return EventPerformer::get($name);
    }

    /**
     * Get all the defined Event Performer instances from the config.
     *
     * @return \Illuminate\Support\Collection<\Melasistema\HydeEventsModule\Framework\Features\Event\Models\EventPerformer>
     */
    public static function all(): Collection
    {
        return EventPerformer::all();
    }
}
