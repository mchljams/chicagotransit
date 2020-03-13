<?php

namespace Mchljams\Chicagotransit\Helpers;

class Routes
{
    const RED    = array('Red', 'Red', 'Howard-95th/Dan Ryan service');
    const BLUE   = array('Blue', 'Blue', 'O’Hare-Forest Park service');
    const BROWN  = array('Brn', 'Brown', 'Kimball-Loop service');
    const GREEN  = array('G', 'Green', 'Harlem/Lake-Ashland/63rd-Cottage Grove service');
    const ORANGE = array('Org', 'Orange', 'Midway-Loop service');
    const PURPLE = array('P', 'Purple', 'Linden-Howard shuttle service');
    const PINK   = array('Pink', 'Pink', '54th/Cermak-Loop service');
    const YELLOW = array('Y', 'Yellow', 'Skokie-Howard [Skokie Swift] shuttle service');

    private static $keys = array('alias', 'name', 'description');

    public static function all()
    {
        return self::getRoutesWithKeys();
    }

    public static function aliases()
    {
        $allRoutes = self::all();

        $aliases = array_map(function($route){
            return $route['alias'];
        }, $allRoutes);

        return $aliases;
    }

    private static function getRoutesWithKeys()
    {
        $routesWithKeys = [];

        foreach(self::getRoutes() as $line) {
            $routesWithKeys[] = array_combine(self::$keys, $line);
        }

        return $routesWithKeys;

    }

    private static function getRoutes() 
    {
        $reflectionClass = new \ReflectionClass(static::class);

        return $reflectionClass->getConstants();
    }
}