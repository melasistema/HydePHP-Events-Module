<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule\Commands;

use Hyde\Console\Commands\PublishHomepageCommand;
use Hyde\Framework\Services\ViewDiffService;
use Hyde\Pages\BladePage;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use function Hyde\unixsum_file;

/**
 * This file is part of the Hyde Events Module package.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola <info@melasistema.com>
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 */

class PublishEventHomepageCommand extends PublishHomepageCommand
{
    /** @var string */
    protected $signature = 'publish:homepage-events {--force : Overwrite any existing files}';

    /** @var string */
    protected $description = 'Publish the Events Feed homepage to index.blade.php';

    /** @var array<string, array{name: string, description: string, group: string}> */
    protected array $options = [
        'events' => [
            'name' => 'Events Feed',
            'description' => 'A feed of your latest events.',
            'group' => 'hyde-events-page',
        ],
    ];

    /** @var string */
    private const SOURCE_FILE = 'vendor/melasistema/hyde-events-module/resources/views/homepages/event-feed.blade.php';

    /** @var string */
    private const TARGET_FILE = '_pages/index.blade.php';

    /** @return string */
    protected function getSourceFilePath(): string
    {
        return base_path(self::SOURCE_FILE);
    }

    /** @return string */
    protected function getTargetFilePath(): string
    {
        return base_path(self::TARGET_FILE);
    }

    public function handle(): int
    {
        // Select the "events" option since this is the only one for this command.
        $selected = 'events';

        if (! $this->canExistingFileBeOverwritten()) {
            $this->error('A modified index.blade.php file already exists. Use --force to overwrite.');
            return 409;
        }

        // Check if the option exists (this will always be true for our specific case).
        $tagExists = array_key_exists($selected, $this->options);

        // Manually publish the index.blade.php file to _pages/
        if ($this->publishHomepageFile()) {
            // If the file was successfully copied
            $this->info("Published Events Feed homepage");

            // Ask if the user wants to rebuild the site
            $this->askToRebuildSite();

            return Command::SUCCESS;
        } else {
            $this->error('Failed to publish the homepage file.');
            return Command::FAILURE;
        }
    }

    /**
     * Manually publish the events homepage file to _pages/index.blade.php
     *
     * @return bool
     */
    protected function publishHomepageFile(): bool
    {
        // Path to the source file in the composer package folder
        $sourceFile = $this->getSourceFilePath();

        // Path to the target file (_pages/index.blade.php)
        $targetFile = $this->getTargetFilePath();

        // Check if the source file exists
        if (!File::exists($sourceFile)) {
            $this->error("Source file '$sourceFile' does not exist.");
            return false;
        }

        // If the force option is used, we overwrite any existing file
        if ($this->option('force') || !File::exists($targetFile)) {
            // Ensure the _pages directory exists
            if (!File::exists(base_path('_pages'))) {
                File::makeDirectory(base_path('_pages'), 0755, true);
            }

            // Copy the file to the target location
            File::copy($sourceFile, $targetFile);

            return true;
        }

        $this->error("The index.blade.php file already exists. Use --force to overwrite.");
        return false;
    }

    protected function parseSelection(): string
    {
        // Override the default parseSelection method to directly return 'events'
        return 'events';
    }

    protected function promptForHomepage(): string
    {
        // Override the prompt to directly return 'events', as this is the only option for this command.
        return 'events';
    }

    protected function formatPublishableChoices(): array
    {
        // Directly return the event-specific options.
        return [
            "<comment>events</comment>: {$this->options['events']['description']}",
        ];
    }

    /** @return Collection<array{name: string, description: string, group: string}> */
    protected function getTemplateOptions(): Collection
    {
        // Return the event-specific options only.
        return new Collection($this->options);
    }

    protected function canExistingFileBeOverwritten(): bool
    {
        // Check if the file can be overwritten, leveraging the base logic.
        if ($this->option('force')) {
            return true;
        }

        if (! file_exists(BladePage::path('index.blade.php'))) {
            return true;
        }

        return $this->isTheExistingFileADefaultOne();
    }

    protected function isTheExistingFileADefaultOne(): bool
    {
        // Use the base method to check if the existing file is the default.
        return ViewDiffService::checksumMatchesAny(unixsum_file(BladePage::path('index.blade.php')));
    }

}