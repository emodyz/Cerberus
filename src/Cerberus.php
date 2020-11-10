<?php

namespace Emodyz\Cerberus;

class Cerberus
{
    public static function config($key = null): \Illuminate\Support\Collection
    {
        switch ($key) {
            case 'roles':
                return collect(config('cerberus.roles'));
            case 'authorizations':
                return collect(config('cerberus.authorizations'));
            case ! null:
                return collect(config('cerberus.'.$key));
            default:
                return collect(config('cerberus'));
        }
    }
}
