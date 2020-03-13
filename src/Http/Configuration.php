<?php

namespace Mchljams\Chicagotransit\Http;

use Mchljams\Chicagotransit\Exceptions\ApiKeyException;
use Mchljams\Chicagotransit\Exceptions\OutputTypeException;

class Configuration
{
    private $trainTrackerApiKey;

    private $busTrackerApiKey;

    private $outputType = 'json';

    public function setTrainTrackerApiKey($key)
    {
        $this->trainTrackerApiKey = $key;
    }

    public function getTrainTrackerApiKey()
    {
        if(is_null($this->trainTrackerApiKey)) {
            throw new ApiKeyException('Train Tracker API key not set');
        }

        return $this->trainTrackerApiKey;
    }

    public function setBusTrackerApiKey($key)
    {
        $this->busTrackerApiKey = $key;
    }

    public function getBusTrackerApiKey()
    {
        if(is_null($this->trainTrackerApiKey)) {
            throw new ApiKeyException('Bus Tracker API key not set');
        }
        return $this->busTrackerApiKey;
    }

    public function setOutputType($outputType = 'json')
    {
        $validOutputTypes = ['json', 'xml'];

        if(!in_array($outputType, $validOutputTypes)) {
            throw new OutputTypeException;
        }

        $this->outputType = $outputType;
    }

    public function getOutputType()
    {
        return $this->outputType;
    }
}
