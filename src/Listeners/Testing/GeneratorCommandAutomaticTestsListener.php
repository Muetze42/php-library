<?php

namespace NormanHuth\Library\Listeners\Testing;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Facades\Artisan;
use ReflectionMethod;

class GeneratorCommandAutomaticTestsListener
{
    /**
     * Classes that should have a test.
     *
     * @var array<int, string>
     */
    protected array $testable = [
        'cast',
        'class',
        'command',
        'controller',
        'enum',
        'job',
        'mail',
        'model',
        'policy',
        'request',
        'rule',
        'scope',
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
    public function handle(CommandFinished $event): void
    {
        $parts = explode(':', $event->command);

        if (
            $parts[0] != 'make' || empty($parts[1]) || ! in_array($parts[1], $this->testable) ||
            ($event->input->hasOption('test')) && $event->input->getOption('test')
        ) {
            return;
        }

        $reflection = new ReflectionMethod(Artisan::all()[$event->command], 'getDefaultNamespace');
        $defaultNamespace = $reflection->invoke(Artisan::all()[$event->command], null);

        Artisan::call('make:test', [
            'name' => trim($defaultNamespace, '\\') . '\\' . $event->input->getArgument('name') . 'Test',
        ]);
    }
}
