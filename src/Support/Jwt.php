<?php

namespace NormanHuth\Library\Support;

class Jwt
{
    /**
     * Encode a string with URL-safe Base64.
     */
    public static function urlSafeBase64Encode(string|array $input): string
    {
        if (!is_string($input)) {
            $input = json_encode($input);
        }

        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * Get an assertion (a JSON web token).
     */
    public static function create(
        SslCertificate $certificate,
        array|string $payload,
        array|string $headers = []
    ): string {
        if (is_array($payload)) {
            $payload = static::urlSafeBase64Encode($payload);
        }
        if (is_array($headers)) {
            $headers = static::urlSafeBase64Encode($headers);
        }

        return implode('.', [
            $headers,
            $payload,
            static::urlSafeBase64Encode(
                $certificate->getPkGeneratedSignature(payload: $payload, headers: $headers)
            ),
        ]);
    }
}
