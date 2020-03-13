<?php 

require __DIR__ . '/vendor/autoload.php';

use Mchljams\Chicagotransit\Helpers\Routes;
use Mchljams\Chicagotransit\Http\Configuration;
use Mchljams\Chicagotransit\CTA\TrainTracker;
use Mchljams\Chicagotransit\CTA\CustomerAlerts;
use Mchljams\Chicagotransit\CTA\BusTracker;

// Set the Client configurations
$configuration = new Configuration();
$configuration->setTrainTrackerApiKey('xxx');
$configuration->setBusTrackerApiKey('xxx');
$configuration->setOutputType('json');


// Initialize the TrainTracker Controller
$trainTracker = new TrainTracker($configuration);
// Initialize the CustomerAlerts Controller
$customerAlerts = new CustomerAlerts($configuration);
// Initialize the Bus Tracker Controller
$busTracker = new BusTracker($configuration);


try {
///////////////////////////////////////////////

// Test the bus tracker
//var_dump($busTracker->time());
//var_dump($busTracker->routes());
//var_dump($busTracker->routeDirections('81'));
//var_dump($busTracker->stops('81','Eastbound'));
//var_dump($busTracker->patterns([],'81'));
//var_dump($busTracker->patterns(['3932']));
//var_dump($busTracker->vehicles([],['22'],'m'));
//var_dump($busTracker->predictions([],[],['1765','4157','4345']));
//var_dump($busTracker->predictions(['14788'],[],[]));
//var_dump($busTracker->predictions([],['22'],['1915'],10));
//var_dump($busTracker->predictions([],['22'],[],10));
    var_dump($busTracker->predictions(['14788']));
} catch (\Exception $e) {
    //print get_class($e);

    $reflect = new ReflectionClass($e);

    print $reflect->getShortName() . ' - ' . $e->getMessage() . "\n";
}


die();
///////////////////////////////////////////////

///////////////////////////////////////////////
// Test the train tracker
var_dump($trainTracker->arrivals('40360'));
$routes = Routes::all();
var_dump($trainTracker->locations($routes));
die();
///////////////////////////////////////////////

///////////////////////////////////////////////
// Test the route helper
$routeAliases = Routes::aliases();
var_dump($routeAliases);
die();
///////////////////////////////////////////////

///////////////////////////////////////////////
// test the customer alerts
var_dump($customerAlerts->routeStatus());
var_dump($customerAlerts->detailedAlerts());
die();
///////////////////////////////////////////////