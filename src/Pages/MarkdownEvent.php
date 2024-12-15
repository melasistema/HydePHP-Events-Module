<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule\Pages;

use Hyde\Foundation\Kernel\PageCollection;
use Hyde\Framework\Features\Blogging\Models\FeaturedImage;
use Hyde\Markdown\Models\FrontMatter;
use Hyde\Markdown\Models\Markdown;
use Hyde\Support\Models\Route;
use Illuminate\Support\Carbon;
use Melasistema\HydeEventsModule\Framework\Features\Event\Models\EventPerformer;
use Melasistema\HydeEventsModule\Markdown\Contracts\FrontMatter\EventPostSchema;
use Hyde\Pages\Concerns\BaseMarkdownPage;
use Hyde\Support\Models\DateString;
use Melasistema\HydeEventsModule\Models\EventDateTime;

use function array_merge;

/**
 * Page class for Markdown events.
 *
 * Markdown events are stored in the _events directory and using the .md extension.
 * The Markdown will be compiled to HTML using the event layout to the _site/events/ directory.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 */
class MarkdownEvent extends BaseMarkdownPage implements EventPostSchema
{
    public static string $sourceDirectory = '_events';
    public static string $outputDirectory = 'events';
    public static string $template = 'hyde-events::layouts/event';

    public ?string $description;
    public ?string $category;

    // Published date (same as blog post date)
    public ?DateString $date;

    // Event specific fields
    public ?EventDateTime $startDateTime; // Start date time of the event
    public ?string $locationName; // Location name of the event
    public ?string $locationAddress; // Location address of the event
    public ?string $link; // External link for the event (like a ticket link)
    public ?EventPerformer $performer;
    // Using the FeaturedImage model to store image data (as default in HydePHP posts)
    public ?FeaturedImage $image;

    /**
     * Construct a new MarkdownEvent object.
     *
     * @param string $identifier
     * @param FrontMatter|array $matter
     * @param Markdown|string $markdown
     * @throws \Exception
     */
    public function __construct(string $identifier = '', FrontMatter|array $matter = [], Markdown|string $markdown = '')
    {
        parent::__construct($identifier, $matter, $markdown);

        // Ensure the 'date' front matter is present and valid
        $date = $this->matter('date');
        if (!$date) {
            throw new \RuntimeException("The 'date' front matter is required for event: {$identifier}");
        }

        // Initialize the DateString object properly
        try {
            $this->date = new DateString($date);  // Convert string to DateString object
        } catch (\Exception $e) {
            throw new \RuntimeException("Invalid date format for event: {$identifier}", 0, $e);
        }

        // Ensure the 'startDateTime' front matter is present and valid
        $startDateTime = $this->matter('startDateTime');
        if ($startDateTime) {
            // Initialize the startDate as DateString if provided
            try {
                $this->startDateTime = new EventDateTime($startDateTime);  // Convert string to DateString object
            } catch (\Exception $e) {
                throw new \RuntimeException("Invalid start date format for event: {$identifier}", 0, $e);
            }
        } else {
            // Default startDate to the same value as 'date' if not provided
            /*$this->startDateTime = $this->date;*/
            $this->startDateTime = new EventDateTime($date);
        }

        $this->description = $this->matter('description') ?: null;
        $this->category = $this->matter('category') ?: null;


        // Initialize locationName, locationAddress, and link
        $this->locationName = $this->matter('locationName') ?: null;
        $this->locationAddress = $this->matter('locationAddress') ?: null;
        $this->link = $this->matter('link') ?: null;

        // Initialize the image object
        $imageData = $this->matter('image');
        if ($imageData) {
            $this->image = new FeaturedImage(
                $imageData['source'],      // Source of the image (e.g., _media/events/central-park-concert.jpg)
                $imageData['altText'] ?? null,   // Alt text (if exists)
                $imageData['title'] ?? null,     // Title text (if exists)
                $imageData['authorName'] ?? null,  // Author's name (if exists)
                $imageData['authorUrl'] ?? null,   // Author's URL (if exists)
                $imageData['licenseName'] ?? null, // License name (if exists)
                $imageData['licenseUrl'] ?? null,  // License URL (if exists)
                $imageData['copyrightText'] ?? null // Copyright text (if exists)
            );
        }


        // Handle 'performer' as before
        $performerData = $this->matter('performer');  // This is expected to be an array with 'name', 'role', 'website', etc.
        if ($performerData && is_array($performerData)) {
            $performerName = $performerData['name'] ?? '';  // Ensure you extract 'name' from the array, defaulting to an empty string
            $performerRole = $performerData['role'] ?? null; // Extract 'role', defaulting to null if not available
            $performerWebsite = $performerData['website'] ?? null; // Extract 'website', defaulting to null if not available

            // Now pass these values to the constructor
            $this->performer = new EventPerformer(
                $performerName,               // Name of the performer (e.g., "Melaband")
                $performerRole,               // Role of the performer (e.g., "musician")
                $performerWebsite            // Website of the performer (e.g., "https://melasistema.com")
            );
        }






    }

    /**
     * Determine if the event should be shown in the navigation.
     *
     * This method is used to determine if the event should be shown in the navigation.
     */
    public function showInNavigation(): bool
    {
        return false; // Prevent individual events from showing in navigation
    }

    /**
     * Get the route for the event page.
     *
     * This method returns a Route object, as expected by HydePHP.
     */
    public function getRoute(): Route
    {
        // Return a Route object, passing in the current MarkdownEvent instance
        return new Route($this);
    }

    /** @return PageCollection<MarkdownEvent> */
    public static function getLatestEvents(): PageCollection
    {
        // Get the current date using Carbon
        $now = Carbon::now(); // Get the current date and time

        return static::all()->sort(function (self $eventA, self $eventB) use ($now) {
            // Get the start date of the two events
            $timestampA = $eventA->startDateTime?->dateTimeObject ? Carbon::instance($eventA->startDateTime->dateTimeObject)->timestamp : PHP_INT_MAX;
            $timestampB = $eventB->startDateTime?->dateTimeObject ? Carbon::instance($eventB->startDateTime->dateTimeObject)->timestamp : PHP_INT_MAX;

            // Compare both events
            if ($timestampA >= $now->timestamp && $timestampB >= $now->timestamp) {
                // Both are future events: Ascending order (closer to now comes first)
                return $timestampA <=> $timestampB;
            } elseif ($timestampA < $now->timestamp && $timestampB < $now->timestamp) {
                // Both are past events: Descending order (more recent past comes first)
                return $timestampB <=> $timestampA;
            } else {
                // One is future and one is past: Future comes first
                return $timestampA >= $now->timestamp ? -1 : 1;
            }
        });
    }

    /**
     * Convert the MarkdownEvent object to an array.
     *
     * This method is used to convert the object to an array, which is then used to render the page.
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'description' => $this->description,
            'category' => $this->category,
            'date' => $this->date,

            // Event specific fields
            'startDateTime' => $this->startDateTime,
            'locationName' => $this->locationName,
            'locationAddress' => $this->locationAddress,
            'link' => $this->link,

            'performer' => $this->performer,
            'image' => $this->image,
        ]);
    }
}
