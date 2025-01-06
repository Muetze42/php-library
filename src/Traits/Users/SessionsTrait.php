<?php

namespace NormanHuth\Library\Traits\Users;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use NormanHuth\Library\Objects\UserSessionObject;
use RuntimeException;

trait SessionsTrait
{
    use UserAgentTrait;

    /**
     * Get the current sessions.
     *
     * @copyright Based on laravel/jetstream https://github.com/laravel/jetstream
     *
     * @param \Illuminate\Foundation\Auth\User|\Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Support\Collection<array-key, \NormanHuth\Library\Objects\UserSessionObject>
     */
    public function existingUserSessions(User|Request $request): Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        if (! class_exists('\Laravel\Jetstream\Agent')) {
            throw new RuntimeException(
                sprintf(
                    'This method need the package `%s%%`. Please run `composer require %1$s`.',
                    'laravel/jetstream',
                )
            );
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', $this->getAuthIdentifier($request))
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session->user_agent);

            return new UserSessionObject(
                agent: $agent,
                session: $session,
                isCurrentDevice: $request instanceof Request ? $session->id === $request->session()->getId() : null
            );
        });
    }

    /**
     * Get the unique identifier for the user.
     *
     * @param \Illuminate\Foundation\Auth\User|\Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function getAuthIdentifier(User|Request $request): mixed
    {
        if ($request instanceof Request) {
            return $request->user()->getAuthIdentifier();
        }

        return $request->getKey();
    }
}
