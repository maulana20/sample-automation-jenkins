<?php

namespace App\Configs;

class BaseConfig
{
    public static function provider($provider) : array
    {
        $config = "\App\\Configs\\" . ucfirst($provider) . "Config";
        return (new $config)();
    }
}