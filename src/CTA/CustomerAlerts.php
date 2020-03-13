<?php

namespace Mchljams\Chicagotransit\CTA;

use Mchljams\Chicagotransit\Http\Controller;

class CustomerAlerts extends Controller
{
    protected $baseUri = 'http://www.transitchicago.com/api/1.0/';
    
    public function routeStatus(
        $type = null, 
        $routeId = null, 
        $stationId = null)
    {
        
        $params = [
            'type' => $type,
            'routeid' => $routeId,
            'stationid' => $stationId
        ];

        return $this->get('routes.aspx', $params);
    }

    public function detailedAlerts(
        $activeOnly = null,
        $accessibility = null,
        $planned = null,
        $routeId = null,
        $stationId = null, 
        $byStartDate = null,
        $recentDays = null ) 
    {

        $params = [
            'activeonly' => $activeOnly,
            'accessibility' => $accessibility,
            'planned' => $planned,
            'routeid' => $routeId,
            'stationid' => $stationId,
            'bystartdate' => $byStartDate,
            'recentdays' => $recentDays
        ];

        return $this->get('alerts.aspx', $params);
    }
}