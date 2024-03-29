<?php

namespace NormanHuth\Library\Macros\Str;

use Closure;

/**
 * @mixin \Illuminate\Support\Str
 */
class Domain
{
    /**
     * Get the domain without subdomain from a URL.
     */
    public function __invoke(): Closure
    {
        return function (string $url): string {
            if (!str_contains($url, '://')) {
                $url = 'https://' . $url;
            }

            $pieces = parse_url($url);
            $domain = $pieces['host'] ?? '';
            if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z.]{2,6})$/i', $domain, $regs)) {
                return $regs['domain'];
            }

            return $domain;
        };
    }
}
