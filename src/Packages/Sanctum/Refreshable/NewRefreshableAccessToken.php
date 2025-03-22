<?php

namespace NormanHuth\Library\Packages\Sanctum\Refreshable;

use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

class NewRefreshableAccessToken extends NewAccessToken
{
    /**
     * The plain text version of the refresh token.
     *
     */
    public string $plainTextRefreshToken;

    /**
     * Create a new access token result.
     */
    public function __construct(PersonalAccessToken $accessToken, string $plainTextToken, string $plainTextRefreshToken)
    {
        $this->plainTextRefreshToken = $plainTextRefreshToken;
        parent::__construct($accessToken, $plainTextToken);
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'accessToken' => $this->accessToken,
            'plainTextToken' => $this->plainTextToken,
            'plainTextRefreshToken' => $this->plainTextRefreshToken,
        ];
    }
}
