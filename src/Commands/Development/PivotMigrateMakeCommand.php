<?php

namespace NormanHuth\Library\Commands\Development;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class PivotMigrateMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:migration:pivot
                            {model1 : The first Model}
                            {model2 : The second Model}
                            {--path= : The location where the migration file should be created}
                            {--filename= : The file name with which the migration should be created}
                            {--id1= : The id column name of the first model}
                            {--id2= : The id column name of the second model}';

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
    protected $type = 'Migration';

    protected string $path;

    protected string $filename;

    protected string $table;

    protected string $table0;

    protected string $table1;

    protected string $snake0;

    protected string $snake1;

    protected string $id1column;

    protected string $id2column;

    /**
     * Execute the console command.
     *
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->path = $this->option('path') ?? '';

        $models = [
            $this->argument('model1'),
            $this->argument('model2'),
        ];
        sort($models);

        $this->table0 = Str::snake(Str::pluralStudly(class_basename($models[0])));
        $this->table1 = Str::snake(Str::pluralStudly(class_basename($models[1])));
        $this->snake0 = Str::snake($models[0]);
        $this->snake1 = Str::snake($models[1]);

        $this->table = $this->snake0 . '_' . $this->snake1;

        $this->filename = $this->option('filename') ?? $this->getFilename();

        $this->id1column = $this->option('id1') ?? 'id';
        $this->id2column = $this->option('id2') ?? 'id';

        $path = $this->getFullPath();

        $this->files->put($path, $this->sortImports($this->buildClass()));

        $this->info($this->type . ' created successfully.');
    }

    protected function getFilename(): string
    {
        return now()->format('Y_m_d_His') . '_create_' . $this->table . '_pivot_table';
    }

    /**
     * Get the full path include filename.
     */
    protected function getFullPath(): string
    {
        $file = str_ends_with($this->filename, '.php') ? $this->filename : $this->filename . '.php';

        return $this->getMigrationPath() . '/' . $file;
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     *
     * @throws FileNotFoundException
     */
    protected function buildClass($name = ''): string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
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
            '{{table}}' => $this->table,
            '{{snake0}}' => $this->snake0,
            '{{snake1}}' => $this->snake1,
            '{{table0}}' => $this->table0,
            '{{table1}}' => $this->table1,
            '{{id1column}}' => $this->id1column,
            '{{id2column}}' => $this->id2column,
        ];

        $stub = str_replace(array_keys($replaces), array_values($replaces), $stub);

        return $this;
    }

    /**
     * Get the migration stub.
     */
    protected function getStub(): string
    {
        $file = base_path('stubs/migration.pivot.stub');
        if (file_exists($file)) {
            return $file;
        }

        return dirname(__DIR__, 3) . '/stubs/laravel/migration.pivot.stub';
    }

    /**
     * Get migration path (either specified by '--path' option or default location).
     */
    protected function getMigrationPath(): string
    {
        return $this->path ?: $this->laravel->basePath() . '/database/migrations';
    }
}
