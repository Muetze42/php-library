<?php

namespace NormanHuth\Library\Commands\Development;

use Illuminate\Foundation\Console\ResourceMakeCommand as Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:resource')]
class ResourceMakeCommand extends Command
{
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name): string
    {
        $contents = parent::buildClass($name);

        $mixin = str_replace($this->getNamespace($name) . '\\', '', $name);

        $word = $this->collection() ? 'Collection' : 'Resource';
        if (str_ends_with($mixin, $word) && strlen($name) > strlen($word)) {
            $mixin = substr($mixin, 0, -strlen($word));

            $contents = str_replace(['{{ mixin }}', '{{mixin}}'], $mixin, $contents);
        }

        return $contents;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->collection()
            ? $this->resolveStubPath('resource-collection.stub')
            : $this->resolveStubPath('resource.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath('stubs/' . trim($stub, '/')))
            ? $customPath
            : dirname(__DIR__, 3) . '/stubs/laravel/' . $stub;
    }
}
