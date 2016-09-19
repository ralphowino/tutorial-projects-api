<?php

namespace App\Http\Middleware;

use Closure;

class VerifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domain = array_get(parse_url($request->url()), 'host');
        $base = array_get(parse_url(config('app.url')), 'host');
        $slug = trim(str_replace($base, '', $domain), '.');
        if (!$slug) {
            return abort(404);
        }

        $tenant = \API::user()->teams()->where('slug', $slug)->firstOrFail();
        \Session::put('tenant', $tenant);

        return $next($request);
    }
}
