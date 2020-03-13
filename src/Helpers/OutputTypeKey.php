<?php

namespace Mchljams\Chicagotransit\Helpers;

class OutputTypeKey
{
    public static function get($apiName)
    {
        switch($apiName) {

            case 'BusTracker':
                return 'format';
                break;
            case 'TrainTracker':
            default:
                return 'outputType';
                break;
        }
    }
}