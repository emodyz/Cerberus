<?php

namespace Emodyz\Cerberus;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Gate;

class AuthorizationRegistrar
{
    // TODO: cache everything

    /**
     * PermissionManager constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Register the permission check method on the gate.
     * We resolve the Gate fresh here, for benefit of long-running instances.
     *
     * @return bool
     */
    public function registerPermissions(): bool
    {
        app(Gate::class)->before(function (Authorizable $user, string $ability) {
            if (method_exists($user, 'checkAuthorizationTo')) {
                return $user->checkAuthorizationTo($ability) ?: null;
            }
        });

        return true;
    }
}
