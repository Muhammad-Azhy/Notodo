<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
public function handle($request, \Closure $next)
{
    if (!$request->user() || !$request->user()->isAdmin()) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    return $next($request);
}

}
