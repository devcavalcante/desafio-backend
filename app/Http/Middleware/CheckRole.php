<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        $types = array_slice(func_get_args(), 2);
        foreach ($types as $type) {
            if (auth()->user()->role->type === $type) {
                return $next($request);
            }
        }
        return response()->json(["Errors" => ["user" => "User needs authorization"]], 403);
    }
}
