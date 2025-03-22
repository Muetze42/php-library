##  composer.json:

```json
{
    "extra": {
        "laravel": {
            "dont-discover": [
                "laravel/sanctum"
            ]
        }
    }
}
```

## AppServiceProvider:

```php
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Laravel\Sanctum\Sanctum::usePersonalAccessTokenModel(\NormanHuth\Library\Packages\Sanctum\Refreshable\PersonalAccessToken::class);
    }
```

## Trait

Use `\NormanHuth\Library\Packages\Sanctum\Refreshable\HasApiTokensTrait` instead of `HasApiTokens` 

## /config/sanctum.php

```php
return [
    /*
    |--------------------------------------------------------------------------
    | Refresh Token
    |--------------------------------------------------------------------------
    |
    | This value controls the number of minutes until an issued token will be
    | must be renewed and is expired. The values are set by default with the
    | `createToken` method of the `HasApiTokensTrait`.
    |
    */

    'refresh' => [
        'expiration' => toMinutes(env('SANCTUM_EXPIRATION', '1m')),
        'valid' => toMinutes(env('SANCTUM_EXPIRATION', '1d')),
    ],
];
```

## Authenticatable Model 

Use `NormanHuth\Library\Packages\Sanctum\Refreshable\HasApiTokensTrait` instead `Laravel\Sanctum\HasApiTokens`

## /bootstrap/providers.php

```php
return [
    NormanHuth\Library\Packages\Sanctum\Refreshable\MigrationServiceProvider::class,
];
```

## Migration

```php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->string('refresh_token', 64)->unique(); // <- New
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('invalid_at')->nullable(); // <- New
            $table->timestamps();
        });
    }
```
