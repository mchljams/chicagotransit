<?php

namespace Mchljams\Chicagotransit\Helpers;

use Mchljams\Chicagotransit\Exceptions\TopParameterException;

class TopParameter
{
    public static function validate($topParameter)
    {
        if(!is_int($topParameter))
        {
            throw new TopParameterException();
        }

        return $topParameter;
    }
}