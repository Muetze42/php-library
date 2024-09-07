<?php

namespace NormanHuth\Library\Listeners\Quality;

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use InvalidArgumentException;
use ReflectionClass;

class GeneratorCommandCodingStandardsListener
{
    /**
     * Classes that should not be suffixed with a type.
     *
     * @var array<int, string>
     */
    protected array $withOutSuffix = [
        'class',
        'component',
        'migration',
        'model',
        'test',
        'view',
    ];

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the name of the listener's queue.
     */
    public function viaQueue(): string
    {
        return 'sync';
    }

    /**
     * Handle the event.
     *
     * @throws \ReflectionException
     */
    public function handle(CommandStarting $event): void
    {
        $parts = explode(':', $event->command);

        if ($parts[0] != 'make' || empty($parts[1])) {
            return;
        }

        if (! $event->input->hasArgument('name')) {
            return;
        }

        $name = $event->input->getArgument('name');

        if (
            ! in_array($parts[1], $this->withOutSuffix) && ! str_contains($parts[1], '-') &&
            is_subclass_of(Artisan::all()[$event->command], GeneratorCommand::class)
        ) {
            $commandInstance = Artisan::all()[$event->command];
            $reflection = new ReflectionClass($commandInstance);
            $type = $reflection->getProperty('type')->getValue($commandInstance);
            $suffix = Str::ucfirst($parts[1]);

            if (
                ! str_ends_with($name, $suffix) &&
                ($event->command != 'make:resource') && ! str_ends_with($name, 'Collection')
            ) {
                throw new InvalidArgumentException(
                    sprintf('Coding Standards mismatch. %s must suffixed with `%s`.', $type, $suffix)
                );
            }
        }

        if ($name == Str::plural($name) && Str::endsWith($name, 's')) {
            throw new InvalidArgumentException('Coding Standards mismatch. Class names must be in singular.');
        }
    }
}
