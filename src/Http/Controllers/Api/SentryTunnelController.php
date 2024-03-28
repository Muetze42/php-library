<?php

namespace NormanHuth\Library\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SentryTunnelController
{
    /**
     * Handle the incoming Sentry error report request.
     */
    public function __invoke(Request $request)
    {
        $envelope = $request->getContent();
        $headers = array_map(
            fn ($line) => json_decode($line, true),
            preg_split('/\r\n|\r|\n/', $envelope)
        )[0];

        if (empty($headers['dsn']) || $headers['dsn'] != config('sentry.dsn')) {
            return response()->json(null, 401);
        }

        $parsed = parse_url(config('sentry.dsn'));
        $url = sprintf(
            'https://%s.ingest.sentry.io/api/%d/envelope/',
            explode('.', $parsed['host'])[0],
            last(explode('/', rtrim($parsed['path'], '/')))
        );

        $response = Http::withBody($envelope, 'application/x-sentry-envelope')->post($url);

        //Log::driver('sentry')->error($envelope); Todo

        return response()->json($response->json(), $response->status());
    }
}
