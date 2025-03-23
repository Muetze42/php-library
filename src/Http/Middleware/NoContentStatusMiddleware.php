<?php

namespace NormanHuth\Library\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoContentStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (empty($response->getContent())) {
            return $response->setStatusCode(Response::HTTP_NO_CONTENT);
        }

        return $next($request);
    }
}
