<?php

namespace App\Http\Middleware;

use Closure;

class HasUserInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if (!$user->first_name || !$user->last_name || !$user->country_code ||
            !$user->city || !$user->address || !$user->zip || !$user->cell_cc || !$user->cell_number) {
            return response()->json([
                'message' => 'You need to update your account information'
            ], 426);
        }

        return $next($request);
    }
}
