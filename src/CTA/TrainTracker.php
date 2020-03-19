<?php

namespace Mchljams\Chicagotransit\CTA;

use Mchljams\Chicagotransit\Http\Controller;

class TrainTracker extends Controller
{
    protected $baseUri = 'http://lapi.transitchicago.com/api/1.0/';

    protected $outputTypeKey = 'outputType';

    public function arrivals($mapId = null, $stopId = null, $max = null, $routeCode = null)
    {
        
        $params = [
            'mapid' => $mapId,
            'stpid' => $stopId,
            'max' => $max,
            'rt' => $routeCode
        ];

        return $this->get('ttarrivals.aspx', $params);
    }

    public function followThisTrain($trainRunNumber = null)
    {

        $params = [
            'runnumber' => $trainRunNumber
        ];

        return $this->get('ttfollow.aspx', $params);
    }

    public function locations($trainRoutes = [])
    {
        $params = [
            'rt' => implode(',', $trainRoutes)
        ];

        return $this->get('ttpositions.aspx', $params);
    }
}