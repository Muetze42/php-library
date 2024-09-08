<?php

namespace NormanHuth\Library\Commands\Development;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class PivotMigrateMakeCommand extends GeneratorCommand implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:migration:pivot
        {model1 : The name of the first Model}
        {model2 : The name of the second Model}
        {--path= : The location where the migration file should be created}
        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
        {--fullpath : Output the full path of the migration (Deprecated)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file for `many-to-many` pivot table';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Pivot Migration';

    /**
     * @var array|string[]
     */
    protected array $imports = [
        'use Illuminate\Database\Migrations\Migration;',
        'use Illuminate\Database\Schema\Blueprint;',
        'use Illuminate\Support\Facades\Schema;',
    ];

    //public function __construct(Filesystem $files)
    //{
    //    //$this->input->setArgument('name', 'Foo');
    //    parent::__construct($files);
    //}

    /**
     * @var string
     */
    protected string $model1;

    /**
     * @var string
     */
    protected string $model2;

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        /** @phpstan-ignore argument.type */
        $model1 = $this->resolveModel($this->argument('model1'));
        /** @phpstan-ignore argument.type */
        $model2 = $this->resolveModel($this->argument('model2'));
        $models = array_values([
            class_basename($model1) => $model1,
            class_basename($model2) => $model2,
        ]);
        sort($models);
        $this->model1 = $models[0];
        $this->model2 = $models[1];

        if (class_exists($this->model1)) {
            $this->imports[] = 'use ' . $this->model1 . ';';
        }
        if (class_exists($this->model2)) {
            $this->imports[] = 'use ' . $this->model2 . ';';
        }
        sort($this->imports);

        $name = Str::snake(
            'Create' . class_basename($this->model1) . class_basename($this->model2) . 'PivotTable'
        );
        $path = $this->getPath($name);

        if ((! $this->hasOption('force') || ! $this->option('force')) && $this->alreadyExists($path)) {
            $this->components->error($this->type . ' already exists.');

            return false;
        }

        $this->files->put($path, $this->buildClass($name));

        if (windows_os()) {
            $path = str_replace('/', '\\', $path);
        }

        $this->components->info(sprintf('%s [%s] created successfully.', $this->type, $path));
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name): string
    {
        $replace = [
            '{{table}}' => Str::snake(class_basename($this->model1)) . '_' . Str::snake(class_basename($this->model2)),
            '{{imports}}' => implode("\n", $this->imports),
            '{{foreign1}}' => $this->getForeignReplace($this->model1),
            '{{foreign2}}' => $this->getForeignReplace($this->model2),
            '{{primary1}}' => $this->getIndexReplace($this->model1),
            '{{primary2}}' => $this->getIndexReplace($this->model2),
        ];

        return str_replace(array_keys($replace), array_values($replace), $stub);
    }

    /**
     * @param  string  $model
     * @return string
     */
    protected function getIndexReplace(string $model): string
    {
        if (class_exists($model)) {
            return '(new ' . class_basename($model) . '())->getForeignKey()';
        }

        return "'" . Str::snake($model) . '_id\'';
    }

    /**
     * @param  string  $model
     * @return string
     */
    protected function getForeignReplace(string $model): string
    {
        if (class_exists($model)) {
            return '$table->foreignIdFor(' . class_basename($model) . '::class)->constrained()->cascadeOnDelete();';
        }

        return '$table->foreignId(\'' . $this->getForeignIdString($model) .
            '\')->constrained(\'' . Str::snake(Str::plural(class_basename($model))) . '\')->cascadeOnDelete();';
    }

    /**
     * @param  string  $model
     * @return string
     */
    protected function getForeignIdString(string $model): string
    {
        return Str::snake(class_basename($model)) . '_id';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        return database_path('migrations' . '/' . $this->getDatePrefix() . '_' . $name . '.php');
    }

    /**
     * @param  string  $model
     * @return string
     */
    protected function resolveModel(string $model): string
    {
        $model = trim($model);

        if (! class_exists($model)) {
            $model = str_replace('/', '\\', ltrim($model, '\\/'));
            $rootNamespace = $this->rootNamespace();
            if (class_exists($rootNamespace . 'Models\\' . $model)) {
                return $rootNamespace . 'Models\\' . $model;
            }
        }

        return $model;
    }

    /**
     * Get the date prefix for the migration.
     *
     * @return string
     */
    protected function getDatePrefix(): string
    {
        $creator = App::get('migration.creator');
        if ($creator instanceof MigrationCreator) {
            if (is_callable([$creator, 'getFormattedDatePrefix'])) {
                return call_user_func([$creator, 'getFormattedDatePrefix']);
            }
        }

        return date('Y_m_d_His');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('migration.create.pivot.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = App::basePath('stubs/' . trim($stub, '/')))
            ? $customPath
            : dirname(__DIR__, 3) . '/stubs/laravel/' . $stub;
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, mixed>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'model1' => ['What is the name of the first Model'],
            'model2' => ['What is the name of the second Model'],
        ];
    }
}
