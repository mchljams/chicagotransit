<?php

namespace Mchljams\Chicagotransit\Entities\BusTracker;

use Mchljams\Chicagotransit\Entities\Entity;

/**
 * Describes a Point entity.
 */
class Point extends Entity
{
    private $seq;
    private $typ;
    private $stpid;
    private $stpnm;
    private $pdist;
    private $lat;
    private $lon;

    public function __construct(\stdClass $values)
    {
        parent::__construct($values);
    }

    public function setSeq(string $seq)
    {
        $this->seq = $seq;
    }

    public function getSeq()
    {
        return $this->seq;
    }

    public function setTyp(string $typ)
    {
        $this->typ = $typ;
    }

    public function getTyp()
    {
        return $this->typ;
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

    public function setPdist(string $pdist)
    {
        $this->pdist = $pdist;
    }

    public function getPdist()
    {
        return $this->pdist;
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