<?php

namespace Mchljams\Chicagotransit\Entities\BusTracker;

use Mchljams\Chicagotransit\Entities\Entity;

/**
 * Describes a Vehicle entity.
 */
class Vehicle extends Entity
{
    private $vid;
    private $des;
    private $lat;
    private $lon;
    private $tablockid;
    private $tatripid;
    private $hdg;
    private $rt;
    private $pid;
    private $tmstmp;
    private $pdist;


    public function __construct(\stdClass $values)
    {
        parent::__construct($values);
    }

    public function setVid(string $vid)
    {
        $this->vid = $vid;
    }

    public function getVid()
    {
        return $this->vid;
    }

    public function setDes(string $des)
    {
        $this->des = $des;
    }

    public function getDes()
    {
        return $this->des;
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

    public function setTablockid(string $tablockid)
    {
        $this->tablockid = $tablockid;
    }

    public function getTablockid()
    {
        return $this->tablockid;
    }

    public function setTatripid(string $tatripid)
    {
        $this->tatripid = $tatripid;
    }

    public function getTatripid()
    {
        return $this->tatripid;
    }

    public function setHdg(string $hdg)
    {
        $this->hdg = $hdg;
    }

    public function getHdg()
    {
        return $this->hdg;
    }

    public function setRt(string $rt)
    {
        $this->rt = $rt;
    }

    public function getRt()
    {
        return $this->rt;
    }

    public function setPid(string $pid)
    {
        $this->pid = $pid;
    }

    public function getPid()
    {
        return $this->pid;
    }

    public function setTmstmp(string $tmstmp)
    {
        $this->tmstmp = $tmstmp;
    }

    public function getTmstmp()
    {
        return $this->tmstmp;
    }

    public function setPdist(string $pdist)
    {
        $this->pdist = $pdist;
    }

    public function getPdist()
    {
        return $this->pdist;
    }
}