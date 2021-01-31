<?php

namespace Emodyz\Cerberus\Traits;

use Emodyz\Cerberus\Facades\Cerberus;
use Emodyz\Cerberus\WildcardAuthorization;
use Illuminate\Support\Collection;

trait HasAuthorizations
{
    public function checkAuthorizationTo(string $action): bool
    {
        foreach ($this->getAuthorizationsAttribute() as $userPermission) {

            $userPermission = new WildcardAuthorization($userPermission);

            if ($userPermission->implies($action)) {
                return true;
            }
        }

        return false;
    }


    public function getAuthorizationsAttribute(): Collection
    {
        $role = $this->getAttribute('role');

        return Cerberus::config('roles.'.$role.'.can');
    }
}
