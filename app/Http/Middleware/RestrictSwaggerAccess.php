<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictSwaggerAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->email === 'ahmet@example.com') {
            return $next($request);
        }

        abort(403, 'Unauthorized access to API documentation');
    }
}
