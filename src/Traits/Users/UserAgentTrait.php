<?php

namespace NormanHuth\Library\Traits\Users;

use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Laravel\Jetstream\Agent;

trait UserAgentTrait
{
    /**
     * Create a new agent instance from the given session.
     *
     * @copyright Based on laravel/jetstream https://github.com/laravel/jetstream
     *
     * @param string|\Illuminate\Http\Request|\Illuminate\Session\Store  $agent
     *
     * @return \Laravel\Jetstream\Agent
     */
    public function createAgent(string|Request|Store $agent): Agent
    {
        $userAgent = $this->getUserAgent($agent);

        return tap(new Agent(), fn (Agent $agent) => $agent->setUserAgent($userAgent));
    }

    /**
     * Get the user agent.
     *
     *
     */
    public function getUserAgent(string|Request|Store $agent): string
    {
        if ($agent instanceof Request) {
            $agent = $agent->userAgent();
        }

        if ($agent instanceof Store) {
            $agent = $agent->user_agent;
        }

        return $agent;
    }
}
