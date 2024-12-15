<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule\Actions;

use Hyde\Framework\Exceptions\FileConflictException;
use Hyde\Facades\Filesystem;
use Melasistema\HydeEventsModule\Pages\MarkdownEvent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Offloads logic for the make:event command.
 *
 * This class is executed when creating a new Markdown Event
 * using the Hyde command, and converts and formats the
 * data input by the user, and then saves the file.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 */
class CreatesNewMarkdownEventFile
{
    protected string $title;
    protected string $description;
    protected string $category;
    protected array $performer;
    protected string $date;
    protected string $identifier;
    protected ?string $startDateTime;
    protected ?string $locationName;
    protected ?string $locationAddress;
    protected ?string $link;
    protected ?string $customContent;

    /**
     * Construct the class.
     *
     * @param  string  $title  The Event Title.
     * @param  string|null  $description  The Event Meta Description.
     * @param  string|null  $category  The Primary Event Category.
     * @param  array|null  $performer  The name of the performer.
     * @param  string|null  $date  Optionally specify a custom date.
     * @param  string|null  $startDateTime  The Event Start Date Time.
     * @param  string|null  $locationName  The Event Location Name.
     * @param  string|null  $locationAddress  The Event Location Address.
     * @param  string|null  $link  The Event Link (e.g., URL for more details).
     * @param  string|null  $customContent  Optionally specify custom event content.
     */
    public function __construct(
        string $title,
        ?string $description,
        ?string $category,
        ?array $performer,
        ?string $date = null,
        ?string $startDateTime = null,
        ?string $locationName = null,
        ?string $locationAddress = null,
        ?string $link = null,
        ?string $customContent = null
    ) {
        $this->title = $title;
        $this->description = $description ?? 'A short description used in previews and SEO';
        $this->category = $category ?? 'events';
        $this->performer = [
            'name' => $performer['name'] ?? '',
            'role' => $performer['role'] ?? '',
            'website' => $performer['website'] ?? '',
        ];
        $this->startDateTime = $startDateTime;
        $this->locationName = $locationName;
        $this->locationAddress = $locationAddress;
        $this->link = $link;
        $this->customContent = $customContent;

        // Default date will still be used for the event published date
        $this->date = Carbon::make($date ?? Carbon::now())->format('Y-m-d H:i');
        $this->identifier = Str::slug($title);
    }

    /**
     * Save the class object to a Markdown file.
     *
     * @param  bool  $force  Should the file be created even if a file with the same path already exists?
     * @return string Returns the path to the created file.
     *
     * @throws FileConflictException if a file with the same identifier already exists and the force flag is not set.
     */
    public function save(bool $force = false): string
    {
        $page = new MarkdownEvent($this->identifier, $this->toArray(), $this->customContent ?? '## Write something awesome about the event.');

        if ($force !== true && Filesystem::exists($page->getSourcePath())) {
            throw new FileConflictException($page->getSourcePath());
        }

        return $page->save()->getSourcePath();
    }

    /**
     * Get the class data as an array.
     *
     * The identifier property is removed from the array as it can't be set in the front matter.
     *
     * @return array{title: string, description: string, category: string, performer: array, date: string, startDate: string|null, startTime: string|null, locationName: string|null, locationAddress: string|null, link: string|null}
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'performer' => [
                "name" => $this->performer['name'],
                "role" => $this->performer['role'],
                "website" => $this->performer['website'],
            ],
            'date' => $this->date, // Default date (published date)
            'startDateTime' => $this->startDateTime,
            'locationName' => $this->locationName,
            'locationAddress' => $this->locationAddress,
            'link' => $this->link,
        ];
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
