<?php

// app/Http/Middleware/FlowApiTokenMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FlowApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (! $token || $token !== config('services.flow_api.token')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
