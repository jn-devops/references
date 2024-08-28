<?php

namespace Homeful\References\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Homeful\References\References
 */
class References extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \FrittenKeeZ\Vouchers\Vouchers::class;
    }
}
