<?php

namespace NormanHuth\Library\Commands\Development;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;

class MacroMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:macro {name : The name of the Macro method}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Macro';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Macro';

    /**
     * The macroable class.
     */
    protected string $macroable;

    /**
     * The macro method.
     */
    protected string $macroMethod;

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle(): void
    {
        $macroables = collect(get_declared_classes())
            ->filter(function (string $class) {
                return str_contains($class, '\\') && in_array(Macroable::class, class_uses($class));
            })
            ->values()
            ->toArray();

        $this->macroable = $this->choice(
            'For which class would you like to create a macro?',
            $macroables,
        );

        $name = Str::studly($this->argument('name'));

        $file = app_path('Support/Macros/' . class_basename($this->macroable) . '/' . $name . 'Macro.php');

        $this->files->put($file, $this->sortImports($this->buildClass($name)));

        $this->components->info(sprintf('Macro %s [%s] created successfully.', $name, $file));
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name): static
    {
        $replaces = [
            '{{method}}' => $name,
            '{{class}}' => class_basename($this->macroable),
            '{{macroable}}' => $this->macroable,
        ];

        $stub = str_replace(array_keys($replaces), array_values($replaces), $stub);

        return $this;
    }

    /**
     * Get the migration stub.
     */
    protected function getStub(): string
    {
        $file = base_path('stubs/macro.stub');
        if (file_exists($file)) {
            return $file;
        }

        return dirname(__DIR__, 3) . '/stubs/macro.stub';
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => [
                'What should the Macro method be named?',
                '',
            ],
        ];
    }
}
