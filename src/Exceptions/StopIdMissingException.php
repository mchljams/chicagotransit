<?php 

namespace Mchljams\Chicagotransit\Exceptions;

class StopIdMissingException extends \Exception 
{
    protected $message = "Route designatiors may only be supplied when one or more stop IDs are provided.";
}