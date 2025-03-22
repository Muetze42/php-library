<?php

namespace NormanHuth\Library\Packages\Sanctum\Refreshable;

use DateTimeInterface;
use Laravel\Sanctum\PersonalAccessToken as Model;

class PersonalAccessToken extends Model
{
    use HasApiTokensTrait {
        generateRefreshTokenString as protected thisGenerateRefreshTokenString;
        generateTokenString as protected thisGenerateTokenString;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'invalid_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'token',
        'refresh_token',
        'abilities',
        'invalid_at',
        'expires_at',
    ];

    /**
     * Refresh the personal access token.
     */
    public function refreshToken(
        ?DateTimeInterface $expiresAt = null,
        ?DateTimeInterface $invalidAt = null
    ): NewRefreshableAccessToken {
        $plainTextToken = $this->thisGenerateTokenString();
        $plainTextRefreshToken = $this->thisGenerateRefreshTokenString();

        if (! $expiresAt && $expiresAt = config('sanctum.refresh.expiration')) {
            $expiresAt = now()->addMinutes($expiresAt);
        }

        if (! $invalidAt && $invalidAt = config('sanctum.refresh.expiration')) {
            $invalidAt = now()->addMinutes($invalidAt);
        }

        $this->update([
            'token' => hash('sha256', $plainTextToken),
            'refresh_token' => hash('sha256', $plainTextRefreshToken),
            'invalid_at' => $invalidAt,
            'expires_at' => $expiresAt,
        ]);

        return new NewRefreshableAccessToken(
            accessToken: $this,
            plainTextToken: $this->getKey() . '|' . $plainTextToken,
            plainTextRefreshToken: $plainTextRefreshToken
        );
    }
}
