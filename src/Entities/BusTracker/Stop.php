<?php

namespace Mchljams\Chicagotransit\Entities\BusTracker;

use Mchljams\Chicagotransit\Entities\Entity;

/**
 * Describes a Direction entity.
 */
class Stop extends Entity
{
    private $stpid;
    private $stpnm;
    private $lat;
    private $lon;

    public function __construct(\stdClass $values)
    {
        parent::__construct($values);
    }

    public function setStpid(string $stpid)
    {
        $this->stpid = $stpid;
    }

    public function getStpid()
    {
        return $this->stpid;
    }

    public function setStpnm(string $stpnm)
    {
        $this->stpnm = $stpnm;
    }

    public function getStpnm()
    {
        return $this->stpnm;
    }

    public function setLat(string $lat)
    {
        $this->lat = $lat;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function setLon(string $lon)
    {
        $this->lon = $lon;
    }

    public function getLon()
    {
        return $this->lon;
    }
}