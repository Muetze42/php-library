# Instruction

Activate or deactivate Models with a boolean column.

## Model migration

```php
\Illuminate\Support\Facades\Schema::create('downloads', function (Blueprint $table) {
    $table->boolean('active');
});
```

## Model Trait

`\NormanHuth\Library\Contracts\Models\CanActivateTrait`
