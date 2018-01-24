<?php

namespace Wwhu\Kdniao\Facades;

use Illuminate\Support\Facades\Facade;

class Kdniao extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kdniao';
    }
}