<?php

namespace Mchljams\Chicagotransit\Entities\BusTracker;

use Mchljams\Chicagotransit\Entities\Entity;
use Mchljams\Chicagotransit\Entities\BusTracker\Point;

/**
 * Describes a Pattern entity.
 */
class Pattern extends Entity
{
    private $pid;
    private $ln;
    private $rtdir;
    private $pt;
   
    public function __construct(\stdClass $values)
    {
        parent::__construct($values);
    }

    public function setPid(string $pid)
    {
        $this->pid = $pid;
    }

    public function getPid()
    {
        return $this->pid;
    }

    public function setLn(string $ln)
    {
        $this->ln = $ln;
    }

    public function getLn()
    {
        return $this->ln;
    }

    public function setRtdir(string $rtdir)
    {
        $this->rtdir = $rtdir;
    }

    public function getRtdir()
    {
        return $this->rtdir;
    }

    public function setPt(\stdClass $pt)
    {
        $this->pt = new Point($pt);
    }

    public function getPt()
    {
        return $this->pt;
    }
}