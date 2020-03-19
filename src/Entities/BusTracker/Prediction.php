<?php

namespace Mchljams\Chicagotransit\Entities\BusTracker;

use Mchljams\Chicagotransit\Entities\Entity;

/**
 * Describes a Direction entity.
 */
class Prediction extends Entity
{
    private $tmstmp;
    private $typ;
    private $stpid;
    private $stpnm;
    private $vid;
    private $dstp;
    private $rt;
    private $rtdir;
    private $des;
    private $prdtm;
    private $dly;
    private $tablockid;
    private $tatripid;
    private $prdctdn;
    private $zone;

    public function __construct(\stdClass $values)
    {
        parent::__construct($values);
    }

    public function setTmstmp(string $tmstmp)
    {
        $this->tmstmp = $tmstmp;
    }

    public function getTmstmp()
    {
        return $this->tmstmp;
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

    public function setVid(string $vid)
    {
        $this->vid = $vid;
    }

    public function getVid()
    {
        return $this->vid;
    }

    public function setDstp(string $dstp)
    {
        $this->dstp = $dstp;
    }

    public function getDstp()
    {
        return $this->dstp;
    }

    public function setRt(string $rt)
    {
        $this->rt = $rt;
    }

    public function getRt()
    {
        return $this->rt;
    }

    public function setRtdir(string $rtdir)
    {
        $this->rtdir = $rtdir;
    }

    public function getRtdir()
    {
        return $this->rtdir;
    }

    public function setDes(string $des)
    {
        $this->des = $des;
    }

    public function getDes()
    {
        return $this->des;
    }

    public function setPrdtm(string $prdtm)
    {
        $this->prdtm = $prdtm;
    }

    public function getPrdtm()
    {
        return $this->prdtm;
    }

    public function setDly(string $dly)
    {
        $this->dly = $dly;
    }

    public function getDly()
    {
        return $this->dly;
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

    public function setPrdctdn(string $prdctdn)
    {
        $this->prdctdn = $prdctdn;
    }

    public function getPrdctdn()
    {
        return $this->prdctdn;
    }

    public function setZone(string $zone)
    {
        $this->zone = $zone;
    }

    public function getZone()
    {
        return $this->zone;
    }
} 