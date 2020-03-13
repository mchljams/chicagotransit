<?php 

namespace Mchljams\Chicagotransit\Exceptions;

class TopParameterException extends \Exception 
{
    protected $message = "The Top Parameter must be an integer";
}