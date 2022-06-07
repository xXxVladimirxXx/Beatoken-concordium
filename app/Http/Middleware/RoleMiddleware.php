<?php

namespace App\Http\Middleware;

use Auth;

class RoleMiddleware
{
    protected $superadmin = ['superadmin'];
    protected $admin      = ['superadmin', 'admin'];
    protected $author     = ['superadmin', 'admin', 'author'];
    protected $user       = ['superadmin', 'admin', 'author', 'middleman', 'user'];

    /**
     * Checking for a suitable role for this route.
     * @param $request
     * @param \Closure $next
     * @param $suitableRole
     * @return mixed
     */
    public function handle($request, \Closure $next, $suitableRole)
    {
        if (in_array(Auth::user()->role->name, $this->{$suitableRole})) {
            return $next($request);
        }

        return response()->json(['message' => "You don't have access"], 423);
    }
}
