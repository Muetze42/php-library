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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $decompress = ''): Response
    {
        if (! $decompress != 'always' && $request->header('Content-Encoding') != 'gzip') {
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
