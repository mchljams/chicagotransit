<?php 

namespace Mchljams\Chicagotransit\Exceptions;

class ControllerBaseUriException extends \Exception 
{
    protected $message = 'Base URI Not Set';
}