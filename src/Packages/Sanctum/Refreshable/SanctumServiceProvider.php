<?php

namespace NormanHuth\Library\Packages\Sanctum\Refreshable;

use Illuminate\Auth\RequestGuard;
use Laravel\Sanctum\SanctumServiceProvider as ServiceProvider;
use NormanHuth\Library\Packages\Sanctum\Refreshable\Guard\SanctumGuard;

class SanctumServiceProvider extends ServiceProvider
{
    /**
     * Register the guard.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @param  array<string, string|null>  $config
     */
    protected function createGuard($auth, $config): RequestGuard
    {
        return new RequestGuard(
            new SanctumGuard($auth, config('sanctum.expiration'), $config['provider']),
            request(),
            $auth->createUserProvider($config['provider'] ?? null)
        );
    }
}
