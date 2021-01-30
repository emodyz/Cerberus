<?php

namespace Emodyz\Cerberus\Traits;

use Emodyz\Cerberus\Facades\Cerberus;
use Illuminate\Support\Collection;

trait HasAuthorizations
{
    public function checkAuthorizationTo(string $action): bool
    {
        $role = $this->getAttribute('role');

        $can = Cerberus::config('roles.'.$role.'.can');

        return $can->contains($action) || $can->contains('*');
    }


    public function getAuthorizationsAttribute(): Collection
    {
        $role = $this->getAttribute('role');

        return Cerberus::config('roles.'.$role.'.can');
    }
}
