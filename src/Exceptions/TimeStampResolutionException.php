<?php 

namespace Mchljams\Chicagotransit\Exceptions;

class TimeStampResolutionException extends \Exception 
{
    protected $message = "Invalid Time Stamp Resolution, must be 'm' or 's'";
}