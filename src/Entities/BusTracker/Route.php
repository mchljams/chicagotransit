<?php

namespace Mchljams\Chicagotransit\Entities\BusTracker;

use Mchljams\Chicagotransit\Entities\Entity;

/**
 * Describes a Route entity.
 */
class Route extends Entity
{
    private $rt;
    private $rtnm;
    private $rtclr;

    public function __construct(\stdClass $values)
    {
        parent::__construct($values);
    }

    public function setRt(string $rt)
    {
        $this->rt = $rt;
    }

    public function getRt()
    {
        return $this->rt;
    }

    public function setRtnm(string $rtnm)
    {
        $this->rtnm = $rtnm;
    }

    public function getRtnm()
    {
        return $this->rtnm;
    }

    public function setRtclr(string $rtclr)
    {
        $this->rtclr = $rtclr;
    }

    public function getRtclr()
    {
        return $this->rtclr;
    }
}