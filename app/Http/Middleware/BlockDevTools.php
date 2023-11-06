<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockDevTools
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if ($request->server('HTTP_USER_AGENT') && preg_match('/Chrome|Firefox/i', $request->server('HTTP_USER_AGENT'))) {
        //     abort(403, 'Acceso denegado');
        // }
        return $next($request);
    }
}
