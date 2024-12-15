<?php

declare(strict_types=1);

namespace Melasistema\HydeEventsModule\Commands;

use Exception;
use Illuminate\Console\Command;
use Melasistema\HydeEventsModule\Actions\CreatesNewMarkdownEventFile;

/**
 * This file is part of the Hyde Events Module package.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola <info@melasistema.com>
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 */

class MakeEventCommand extends Command
{
    /** @var string */
    protected $signature = 'make:event
                            {title? : The title for the Event. Will also be used to generate the filename}
                            {--force : Should the generated file overwrite existing events with the same filename?}';

    /** @var string */
    protected $description = 'Scaffold a new Markdown event file';

    public function handle(): int
    {
        $this->title('Creating a new event!');

        $title = $this->getTitle();

        [$description, $category] = $this->getSelections();

        $performer = $this->getPerformerDetails();

        $startDateTime = $this->askForString('What is the start date and time of the event? (YYYY-MM-DD HH:MM)');
        $locationName = $this->askForString('What is the location name of the event?');
        $locationAddress = $this->askForString('What is the address of the event?');
        $link = $this->askForString('Do you have a link for the event? (optional)');

        $creator = new CreatesNewMarkdownEventFile($title, $description, $category, $performer, null, $startDateTime, $locationName, $locationAddress, $link);

        $this->displaySelections($creator);

        if (! $this->confirm('Do you wish to continue?', true)) {
            $this->info('Aborting.');

            return \Hyde\Console\Concerns\Command::USER_EXIT;
        }

        return $this->createPostFile($creator);
    }


    protected function getTitle(): string
    {
        $this->line($this->argument('title')
            ? '<info>Selected title: '.$this->argument('title')."</info>\n"
            : 'Please enter the title of the event, it will be used to generate the filename.'
        );

        return $this->argument('title')
            ?? $this->askForString('What is the title of the event?')
            ?? 'My New Event';
    }

    /** @return array<?string> */
    protected function getSelections(): array
    {
        $this->line('Tip: You can just hit return to use the defaults.');

        $description = $this->askForString('Write a short event excerpt/description');
        $category = $this->askForString('What is the primary category of the event?');

        return [$description, $category];
    }

    protected function displaySelections_OLD(CreatesNewMarkdownEventFile $creator): void
    {
        $this->info('Creating a event with the following details:');

        foreach ($creator->toArray() as $key => $value) {
            $this->line(sprintf('%s: %s', ucwords($key), $value));
        }

        $this->line("Identifier: {$creator->getIdentifier()}");
    }

    protected function displaySelections(CreatesNewMarkdownEventFile $creator): void
    {
        $this->info('Creating an event with the following details:');

        foreach ($creator->toArray() as $key => $value) {
            // Check if the value is an array or an object and format it for display
            if (is_array($value)) {
                $this->line(sprintf('%s:', ucwords($key)));
                foreach ($value as $subKey => $subValue) {
                    $this->line(sprintf('  - %s: %s', ucwords($subKey), $subValue));
                }
            } else {
                $this->line(sprintf('%s: %s', ucwords($key), $value));
            }
        }

        $this->line("Identifier: {$creator->getIdentifier()}");
    }


    /** @return array */
    protected function getPerformerDetails(): array
    {
        return [
            'name' => $this->askForString('What is the performer\'s name?'),
            'role' => $this->askForString('What is the performer\'s role?'),
            'website' => $this->askForString('What is the performer\'s website?'),
        ];
    }


    protected function createPostFile(CreatesNewMarkdownEventFile $creator): int
    {
        try {
            $path = $creator->save($this->option('force'));
            $this->info("Event created! File is saved to $path");

            return Command::SUCCESS;
        } catch (Exception $exception) {
            $this->error('Something went wrong when trying to save the file!');
            $this->warn($exception->getMessage());

            if ($exception->getCode() === 409) {
                $this->comment('If you want to overwrite the file supply the --force flag.');
            }

            return (int) $exception->getCode();
        }
    }

    private function title(string $string)
    {
        return $this->line("<info>$string</info>");
    }

    private function askForString(string $string)
    {
        return $this->ask($string);
    }
}
