<?php

namespace st8113\Yaml;

use Illuminate\Support\Facades\Facade;

class Yaml extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'yaml';
    }
}