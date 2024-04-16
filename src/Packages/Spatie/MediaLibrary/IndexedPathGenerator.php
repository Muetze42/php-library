<?php

namespace NormanHuth\Library\Packages\Spatie\MediaLibrary;

use Illuminate\Support\Number;
use Illuminate\Support\Str;
use NormanHuth\Library\Lib\MacroRegistry;
use NormanHuth\Library\Support\Macros\Number\IndexNumberMacro;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class IndexedPathGenerator implements PathGenerator
{
    /**
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media) . '/';
    }

    /**
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . '/conversions/';
    }

    /**
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    /**
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        $prefix = rtrim(config('media-library.prefix', ''), '/');
        $prefix .= '/' . Str::kebab(Str::plural(class_basename($media->model_type)));
        if (config('media-library.path-index-steps', 100)) {
            $prefix .= '/' . $this->getIndexNumber($media->getKey());
        }

        return $prefix . '/' . $media->getKey();
    }

    /**
     * Get index number for a unique base path for the given media.
     */
    protected function getIndexNumber(int $key): int
    {
        MacroRegistry::macro(IndexNumberMacro::class, Number::class);

        /** @noinspection PhpUndefinedMethodInspection */
        return Number::indexNumber($key);
    }
}
