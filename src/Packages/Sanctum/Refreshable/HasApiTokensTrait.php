<?php

namespace NormanHuth\Library\Packages\Sanctum\Refreshable;

use DateTimeInterface;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;

/**
 * @template TToken of \Laravel\Sanctum\Contracts\HasAbilities = \NormanHuth\Library\Packages\Sanctum\Refreshable\PersonalAccessToken
 */
trait HasApiTokensTrait
{
    /**
     * @use \Laravel\Sanctum\HasApiTokens<TToken>
     */
    use HasApiTokens;

    /**
     * Create a new personal access token for the user.
     */
    public function createToken(
        string $name,
        array $abilities = ['*'],
        ?DateTimeInterface $expiresAt = null,
        ?DateTimeInterface $invalidAt = null
    ): NewAccessToken {
        $plainTextToken = $this->generateTokenString();
        $plainTextRefreshToken = $this->generateRefreshTokenString();

        if (! $expiresAt && $expiresAt = config('sanctum.refresh.expiration')) {
            $expiresAt = now()->addMinutes($expiresAt);
        }

        if (! $invalidAt && $invalidAt = config('sanctum.refresh.expiration')) {
            $invalidAt = now()->addMinutes($invalidAt);
        }

        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken),
            'refresh_token' => hash('sha256', $plainTextRefreshToken),
            'abilities' => $abilities,
            'invalid_at' => $invalidAt,
            'expires_at' => $expiresAt,
        ]);

        return new NewRefreshableAccessToken(
            accessToken: $token,
            plainTextToken: $token->getKey() . '|' . $plainTextToken,
            plainTextRefreshToken: $plainTextRefreshToken
        );
    }

    /**
     * Generate the refresh token string.
     *
     */
    public function generateRefreshTokenString(): string
    {
        return sprintf(
            '%s%s%s',
            config('sanctum.token_prefix', config('sanctum.refresh_token_prefix', '')),
            $tokenEntropy = Str::random(50),
            hash('crc32b', $tokenEntropy)
        );
    }
}
