<?php
/**
 * BusTracker.php
 * @author    Michael James
 * @license   TBD
 * @see       TBD
 */

namespace Mchljams\Chicagotransit\CTA;

use Mchljams\Chicagotransit\Http\Controller;
use Mchljams\Chicagotransit\Http\Results;
use Mchljams\Chicagotransit\Helpers\TimeStampResolution;
use Mchljams\Chicagotransit\Helpers\TopParameter;
use Mchljams\Chicagotransit\Exceptions\StopIdMissingException;
use Mchljams\Chicagotransit\Exceptions\EntityUndefinedException;

/**
 * Controller for the CTA Bus Tracker
 * 
 * The Bus Tracker API allows developers to request and retrieve data directly from BusTime (the system which 
 * produces estimated arrival times and which provides location and route information in real-time).
 * 
 * @package mchljams/chicagotransit
 */
class BusTracker extends Controller
{
    const ENTITIES_NAMESPACE = 'Mchljams\\Chicagotransit\\Entities\\BusTracker\\';

    protected $baseUri = 'http://www.ctabustracker.com/bustime/api/v2/';

    protected $outputTypeKey = 'format';

    /**
     * Use the time request to retrieve the current system date and time. 
     * Since BusTime is a time-dependent system, it is important to synchronize 
     * your application with BusTime’s system date and time.
     * 
     * The time specified is the local time.
     * 
     * @return string the current system date and time
     */
    public function time()
    {
        // make the request and decode the json in to an object
        $request = json_decode($this->get('gettime'));
        // return the date and time string
        return $request->{'bustime-response'}->tm;
    }

    /**
     * Use the vehicles method to retrieve vehicle information (i.e., locations)
     * of all or a subset of vehicles currently being tracked by BusTime.
     * 
     * Use the vid parameter to retrieve information for one or more vehicles 
     * currently being tracked.
     * 
     * Use the rt parameter to retrieve information for vehicles currently running 
     * one or more of the specified routes.
     * 
     * Note: The vid and rt parameters cannot be combined in one request. If both 
     * parameters are specified on a request to getvehicles, only the first parameter 
     * specified on the request will be processed.
     * 
     * @param array $vid array of vehicle IDs (not available with rt parameter)
     * @param array $rt array of of route designators (not available with vid parameter)
     * @param array $tmres Resolution of time stamps. Set to “s” to get time resolution 
     *              to the second. Set to “m” to get time resolution to the minute.
     *              If omitted, defaults to “m”.
     * 
     * @return ArrayIterator results from the http request
     */
    public function vehicles(array $vid = [], array $rt = [], $tmres = 'm')
    {
        // create an empty array to add the param key value pairs to
        $params = [];
        // check if the $vid param is not empty
        if(!empty($vid)) {
            // add the comma separated list of vehicle ids
            $params['vid'] = implode(',',$vid);
        }
        // check if the  $rt param is not empty
        if(!empty($rt)) {
            // add the comma separated list of route ids
            $params['rt'] = implode(',',$rt);
        }
        // validate the time stamp resolution, and set the parameter to the result
        $params['tmres'] = TimeStampResolution::validate($tmres);
        // make the request and decode the json in to an object
        $request = json_decode($this->get('getvehicles', $params));
         // create a response and return
        return $this->bustimeResponse($request, 'vehicle', self::ENTITIES_NAMESPACE . 'Vehicle');
    }

    /**
     * Use the getroutes request to retrieve the set of routes serviced by the system.
     * 
     * @return ArrayIterator results from the http request
     */
    public function routes()
    {
        // make the request and decode the json in to an object
        $request = json_decode($this->get('getroutes'));
        // create a response and return 
        return $this->bustimeResponse($request, 'routes', self::ENTITIES_NAMESPACE . 'Route');
    }

    /**
     * Use the routeDirections method to retrieve the set of directions 
     * serviced by the specified route.
     * 
     * @param string $rt Single route designator(required)
     * 
     * @return ArrayIterator results from the http request
     */
    public function routeDirections($rt)
    {
        $params = [
            'rt' => $rt
        ];
        // make the request and decode the json in to an object
        $request = json_decode($this->get('getdirections', $params));
        // create a response and return 
        return $this->bustimeResponse($request, 'directions', self::ENTITIES_NAMESPACE . 'RouteDirection');
    }

    /**
     * Use the getstops method to retrieve the set of stops for the specified 
     * route and direction. 
     * 
     * Stop lists are only available for a valid route/direction pair. 
     * In other words, a list of all stops that service a particular 
     * route (regardless of direction) cannot be requested.
     * 
     * @param string $rt Single route designator(required)
     * @param string $dir Single route direction(required)
     * 
     * @return ArrayIterator results from the http request
     */
    public function stops($rt, $dir)
    {
        $params = [
            'rt' => $rt,
            'dir' => $dir
        ];

        // make the request and decode the json in to an object
        $request = json_decode($this->get('getstops', $params));
        // create a response and return 
        return $this->bustimeResponse($request, 'stops', self::ENTITIES_NAMESPACE . 'Stop');
    }

    /**
     * Use the patterns method to retrieve the set of geo-positional points 
     * and stops that when connected can be used to construct the geo-positional 
     * layout of a pattern (i.e., route variation).
     * 
     * Note: to get a pattern id ($pid), use the vehicles method to get a 
     * pattern id for a single vehicle
     * 
     * Use $pid to specify one or more identifiers of patterns whose points are 
     * to be returned. A maximum of 10 patterns can be specified.
     * 
     * Use $rt to specify a route identifier where all active patterns are returned. 
     * The set of active patterns returned includes: one or more patterns for the 
     * specified route (all patterns that are currently being executed by at least 
     * one vehicle on the specified route).
     * 
     * Note: The $pid and $rt parameters cannot be combined in one request. If both 
     * parameters are specified on a request to getpatterns, only the first parameter 
     * specified on the request will be processed.
     * 
     * @param array $pid array of pattern IDs (not available with rt parameter)
     * @param string $rt Single route designator (not available with pid parameter)
     * 
     * @throws Exception when more than 10 patterns have been specified.
     * 
     * @return ArrayIterator results from the http request
     */
    public function patterns(array $pid = null, $rt = null)
    {
        // create the parameters array
        $params = [];

        // check if one or more pattern IDs have been provided 
        if($pid) {

            if(count($pid) <= 10) {
            // add the pattern IDs to the parameters
                $params['pid'] = implode(',', $pid);
            } else {
                // throw exception be
                throw new \Exception('A maxium of 10 patterns can be specified');
            }
        }

        if($rt) {
            $params['rt'] = $rt;
        }

        // make the request and decode the json in to an object
        $request = json_decode($this->get('getpatterns', $params));
        // create a response and return 
        return $this->bustimeResponse($request, 'ptr', self::ENTITIES_NAMESPACE . 'Pattern');
    }

    /**
     * Use the predictions method to retrieve predictions 
     * for one or more stops or one or more vehicles. Predictions are 
     * always returned in ascending order according to the prediction time.
     * 
     * Use the $vid parameter to retrieve predictions for one or more vehicles 
     * currently being tracked. A maximum of 10 vehicles can be specified.
     * 
     * Use the $stpid parameter to retrieve predictions for one or more stops. 
     * A maximum of 10 stops can be specified.
     * 
     * Note: The $vid and $stpid parameters cannot be combined in one request. 
     * If both parameters are specified on a request to getpredictions, 
     * only the first parameter specified on the request will be processed.
     * 
     * Calls to getpredictions without specifying the vid or stpid 
     * parameter is not allowed.
     * 
     * Use the $top parameter to specify the maximum number of predictions 
     * to return. If top is not specified, then allpredictions matching 
     * the specified parameters will be returned.
     * 
     * @param array $stpid array of stop ID strings (not available with vid parameter)
     * @param array $rt array of route designators (optional, available with stpid parameter)
     * @param array $vid array of vehicle IDs (not available with stpid parameter)
     * @param string $top maximum number of predictions to be returned.
     * 
     * @throws StopIdMissingException when no stop IDs have been provided.
     * 
     * @return ArrayIterator results from the http request
     */
    public function predictions(array $stpid = null, array $rt = null, array $vid = [], $top = null)
    {
        // create the parameters array
        $params = [];

        // check if one or more stop IDs have been provided 
        if($stpid) {
            // add the stop IDs to the pa
            $params['stpid'] = implode(',', $stpid);
        }

        // check if one or more route designators have been provided
        if($rt) {
            // route designators may only be provided when
            // one or more stop ID's have been provided
            if (!$stpid) {
                // no stop IDs have been provided, so throw an exception
                throw new StopIdMissingException;
            }
            // add the route designators to the parameters
            $params['rt'] = implode(',', $rt);
        }

        // check if one more more vehicle id have been provided
        if($vid) {
            // add the vehicle IDs to the parameters
            $params['vid'] = implode(',', $vid);
        }

        // check if a results limit (top) is set
        if($top) {
            // add the limit to the parameters
            $params['top'] = TopParameter::validate($top);
        }
        // make the request and decode the json in to an object
        $request = json_decode($this->get('getpredictions', $params));
        // create a response and return 
        return $this->bustimeResponse($request, 'prd', self::ENTITIES_NAMESPACE . 'Prediction');
    }

    /**
     * The Service Bulletins API in the Bus Tracker system to considered to be 
     * deprecated, please use the Customer Alerts API.
     * 
     * @throws Exception to indicade deprication.
     * 
     * @return void
     */
    public function serviceBulletins()
    {
        throw new \Exception('Depricated, please use Customer Alerts API');
    }

    /**
     * @param stdClass $request 
     * @param string $key
     * @param string $entityType
     * 
     * @throws Exception when entity provided by name does not exist.
     * 
     * @return ArrayIterator results from the http request
     */
    protected function bustimeResponse(\stdClass $request, string $key, string $entityType)
    {
        if (!class_exists($entityType)) {
            throw new EntityUndefinedException;
        }
        // get the vehicles from the request object
        $items = $request->{'bustime-response'}->{$key};
        // create a new results object
        $results = new Results();
        // loop through the vehicles
        foreach($items as $item) {
            $entity = new $entityType($item);
            // create a vehicle object and add to the results
            $results->add($entity);
        }
        // return the ArrayIterator object
        return $results->getIterator();
    }
}