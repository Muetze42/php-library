<?php

namespace NormanHuth\Library\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

class AddContextMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Context::add('url', $request->url());

        /* phpstan -_- */
        //Context::when(
        //    $user = $request->user(),
        //    fn ($context) => $context->add('auth', [
        //        'authenticatable' => get_class($user),
        //        'key' => $user->getKey(),
        //    ]),
        //    fn ($context) => $context->add('auth', null),
        //);

        $user = $request->user();
        Context::add('auth', is_null($user) ? null : [
            'authenticatable' => get_class($user),
            'key' => $user->getKey(),
        ]);

        return $next($request);
    }
}
