<?php

namespace App\Http\Middleware;

use App\Helpers\RoleChecker;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        if (Auth::user() && RoleChecker::isAdmin()) {
            return $next($request);
        }

        return redirect()->route('account.index');
    }
}