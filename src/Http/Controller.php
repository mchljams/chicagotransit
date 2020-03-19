<?php

namespace Mchljams\Chicagotransit\Http;

use Mchljams\Chicagotransit\Exceptions\ControllerBaseUriException;
use Mchljams\Chicagotransit\Exceptions\ControllerOutputTypeKeyException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class Controller
{
    private $apiKey;

    private $client;

    protected $baseUri = null;

    protected $outputTypeKey = null;

    protected $outputType = 'json';

    public function __construct($apiKey, Client $client = null)
    {
        $this->apiKey = $apiKey;

        $this->client = is_null($client) ?  new Client() : $client;
    }

    private function getRequestUri($path, $params = []) 
    {
        // add the key to the params
        $params['key'] = $this->apiKey;

        $outputTypeKey = $this->getOutputTypeKey();
        
        $params[$outputTypeKey] = $this->outputType;

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

    private function getOutputTypeKey()
    {
        // the base uri must be set by the extending class
        if(!isset($this->outputTypeKey)){
            throw new ControllerOutputTypeKeyException;
        }

        return $this->outputTypeKey;
    }

    protected function get($endpoint, $params = []) {

        $uri = $this->getRequestUri($endpoint, $params);

        $response = $this->client->get($uri);

        return $response->getBody()->getContents();
    }
}