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
        $possibleOrigins = [
            'https://sbanken.logobror.no',
            'https://zeipt.logobror.no'
        ];

        if (in_array($request->header('origin'), $possibleOrigins)) {
            $origin = $request->header('origin');
        } else {
            $origin = 'https://zeipt.logobror.no';
        }
        return $next($request)
            ->header('Access-Control-Allow-Origin', $origin)
            ->header('Vary', 'Origin')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH')
            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Auth-Token, Authorization, Origin');
    }
}
