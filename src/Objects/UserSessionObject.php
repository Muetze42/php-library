<?php

namespace NormanHuth\Library\Objects;

use Illuminate\Support\Carbon;
use Laravel\Jetstream\Agent;

class UserSessionObject
{
    /**
     * @var array{
     *     is_desktop: bool,
     *     platform: string,
     *     browser: string,
     * }
     */
    public array $agent;

    public string $ip_address;

    public ?bool $is_current_device;

    public int $last_active_ts;

    public string $last_active;

    /**
     * Create a new UserSessionObject instance.
     */
    public function __construct(Agent $agent, object $session, ?bool $isCurrentDevice = null)
    {
        $this->agent = [
            'is_desktop' => $agent->isDesktop(),
            'platform' => $agent->platform(),
            'browser' => $agent->browser(),
        ];

        $this->ip_address = $session->ip_address;
        $this->is_current_device = $isCurrentDevice;
        $this->last_active_ts = $session->last_activity;
        $this->last_active = Carbon::createFromTimestamp($session->last_activity)->diffForHumans();
    }
}
