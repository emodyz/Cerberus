<?php

namespace Emodyz\Cerberus\Traits;

use Emodyz\Cerberus\Facades\Cerberus;
use Illuminate\Database\Eloquent\Model;

trait HasAuthorizations
{
    public function checkAuthorizationTo(string $action): bool
    {
        // $subjectId = $this->{$this->getKeyName()};

        $role = $this->getAttribute('role');

        $can = Cerberus::config('roles.'. $role .'.can');

        return $can->contains($action) || $can->contains('*');
    }
}
