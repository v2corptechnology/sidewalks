<?php

namespace App\Http\Middleware;

use Closure;

class VerifyUserHaShop
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
        if ($request->user() && ! $request->user()->hasShop()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
