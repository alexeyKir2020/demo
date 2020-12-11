<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Closure;


class ProvideName
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
