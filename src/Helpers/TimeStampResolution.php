<?php

namespace Mchljams\Chicagotransit\Helpers;

use Mchljams\Chicagotransit\Exceptions\TimeStampResolutionException;

class TimeStampResolution
{
    public static function validate($timeStampResolution)
    {
        if(!in_array($timeStampResolution, ['m','s']))
        {
            throw new TimeStampResolutionException();
        }

        return $timeStampResolution;
    }
}