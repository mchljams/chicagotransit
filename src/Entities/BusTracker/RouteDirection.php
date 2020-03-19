<?php

namespace Mchljams\Chicagotransit\Entities\BusTracker;

use Mchljams\Chicagotransit\Entities\Entity;

/**
 * Describes a Direction entity.
 */
class RouteDirection extends Entity
{
    private $dir;

    public function __construct(\stdClass $values)
    {
        parent::__construct($values);
    }

    public function setDir(string $dir)
    {
        $this->dir = $dir;
    }

    public function getDir()
    {
        return $this->dir;
    }
}