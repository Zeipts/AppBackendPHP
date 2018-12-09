<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->server('HTTP_REFERER') == 'https://sbanken.logobror.no/') {
            return $next($request)
                ->header('Access-Control-Allow-Origin', 'https://sbanken.logobror.no')
                ->header('Vary', 'Origin')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH')
                ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Auth-Token, Authorization, Origin');
        } else {
            return $next($request)
                ->header('Access-Control-Allow-Origin', 'https://zeipt.logobror.no')
                ->header('Vary', 'Origin')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH')
                ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Auth-Token, Authorization, Origin');
        }
    }
}
