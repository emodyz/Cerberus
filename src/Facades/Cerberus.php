<?php

namespace Emodyz\Cerberus\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Cerberus
 * @package Emodyz\Cerberus\Facades
 * @method static \Illuminate\Support\Collection config(null|string $key)
 *
 * @see \Emodyz\Cerberus\Cerberus
 */
class Cerberus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cerberus';
    }
}
