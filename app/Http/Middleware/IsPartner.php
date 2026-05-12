<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPartner
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->isPartner()) {
            abort(403, 'Akses khusus mitra.');
        }

        return $next($request);
    }
}
