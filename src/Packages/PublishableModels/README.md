# Instruction

Activate or deactivate Models with a timestamp columns.

## Register Macro

For example: \App\Providers\AppServiceProvider

```php
    /**
     * Register any application services.
     */
    public function register(): void
    {
        \NormanHuth\Library\Lib\MacroRegistry::macro(
            \NormanHuth\Library\Support\Macros\Blueprint\PublishableMacro::class,
            \Illuminate\Database\Schema\Blueprint::class
        );
    }
```

## Model migration

Migration for Models

```php
\Illuminate\Support\Facades\Schema::create('articles', function (Blueprint $table) {
    $table->publishable();
});
```

## Model Trait

```php
\NormanHuth\Library\Traits\Models\PublishableTrait::class
```
