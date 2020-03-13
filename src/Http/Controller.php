<?php

namespace Mchljams\Chicagotransit\Http;

use Mchljams\Chicagotransit\Http\Configuration;
use Mchljams\Chicagotransit\Exceptions\ControllerBaseUriException;
use Mchljams\Chicagotransit\Helpers\OutputTypeKey;
use GuzzleHttp\Client;

class Controller
{
    private $configuration;

    private $client;

    protected $baseUri = null;

    public function __construct(Configuration $configuration, Client $client = null)
    {
        $this->configuration = $configuration;

        $this->client = is_null($client) ?  new Client() : $client;
    }

    private function getRequestUri($path, $params = []) 
    {

        // fetch the api key if one is required
        $key = $this->getApiKey();
        // check the the key exists
        if($key) {
            // add the key to the params
            $params['key'] = $key;
        }

        $outputTypeKey = OutputTypeKey::get($this->getCallingClass());
        
        $params[$outputTypeKey] = $this->configuration->getOutputType();

        $encodedParams = http_build_query($params);

        return $this->getBaseUri()  . $path . '?' .$encodedParams;
    }

    private function getBaseUri()
    {
        // the base uri must be set by the extending class
        if(!isset($this->baseUri)){
            throw new ControllerBaseUriException;
        }

        return $this->baseUri;
    }

    private function getApiKey()
    {
        // assemble the get key method
        $keyMethod = 'get' . $this->getCallingClass() . 'ApiKey';
        // check that the method exists on the config
        if(method_exists($this->configuration, $keyMethod))
        {
            // fetch the key and return (call dynamically based on key method)
            return $this->configuration->{$keyMethod}();
        } 
        // no key required
        return false;
    }

    private function getCallingClass() {
        $reflect = new \ReflectionClass($this);

        return $reflect->getShortName();
    }

    protected function get($endpoint, $params = []) {

        $uri = $this->getRequestUri($endpoint, $params);

        $response = $this->client->get($uri);

        return $response->getBody()->getContents();
    }
}