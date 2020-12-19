<?php

namespace Emodyz\Cerberus\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if ($request->user()->getAttribute('role') !== $role) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
