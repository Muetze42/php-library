<?php

namespace NormanHuth\Library\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DecompressMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $decompress
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $decompress = ''): Response
    {
        if (! $decompress != 'always' || ! in_array('gzip', (array) $request->header('Content-Encoding'))) {
            return $next($request);
        }

        $request->headers->set('Accept-Encoding', 'gzip, deflate');

        $content = $request->getContent();
        if ($uncompressed = gzdecode($content)) {
            $content = $uncompressed;
        }

        $request = Request::create(
            uri: $request->url(),
            method: $request->method(),
            parameters: $request->all(),
            cookies: $request->cookies->all(),
            files: $request->files->all(),
            server: $request->server->all(),
            content: $content
        );

        app()->instance(Request::class, $request);

        return $next($request);
    }
}
