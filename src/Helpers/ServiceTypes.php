<?php

namespace Mchljams\Chicagotransit\Helpers;

class ServiceTypes
{
    const BUS         = array('bus', 'B');
    const RAIL        = array('rail', 'R');
    const STATION     = array('station', 'T');
    const SYSTEMWIDE  = array('systemwide', 'X');

    private static $keys = array('alias', 'code');

    public static function all()
    {
        return self::getServiceTypesWithKeys();
    }

    public static function aliases()
    {
        $allTypes = self::all();

        $types = array_map(function($type){
            return $type['alias'];
        }, $allTypes);

        return $types;
    }

    private static function getServiceTypesWithKeys()
    {
        $routesWithKeys = [];

        foreach(self::getServiceTypes() as $type) {
            $routesWithKeys[] = array_combine(self::$keys, $type);
        }

        return $routesWithKeys;

    }

    private static function getServiceTypes() 
    {
        $reflectionClass = new \ReflectionClass(static::class);

        return $reflectionClass->getConstants();
    }
}