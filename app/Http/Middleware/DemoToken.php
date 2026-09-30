<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ponytail: One token grants access to all trips. Add user accounts for private data.
class DemoToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('demo.api_token');
        if ($expected === '') {
            return response()->json(['message' => 'Demo API is not configured.'], 503);
        }
        if (! hash_equals($expected, (string) $request->bearerToken())) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        return $next($request);
    }
}
