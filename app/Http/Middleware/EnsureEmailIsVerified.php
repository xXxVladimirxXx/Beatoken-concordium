<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'You need to confirm your account. We have sent you an activation link to your email.'
            ], 424);
        }

        return $next($request);
    }
}
