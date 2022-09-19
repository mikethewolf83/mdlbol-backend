<?php

namespace App\Http\Middleware;

use Closure;

class RequestAcceptJson
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
        $acceptHeader = strtolower($request->headers->get('accept'));

        if ($acceptHeader !== 'application/json') {
            $request->headers->set('Accept', 'application/json');
        }

        // Pre-Middleware Action

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
