<?php

namespace Mchljams\Chicagotransit\Tests\Unit\Http;

use Mchljams\Chicagotransit\Tests\Unit\TestCase;
use Mchljams\Chicagotransit\Tests\Unit\Http\Mocks\MockController as Controller;
use Mchljams\Chicagotransit\Exceptions\ControllerBaseUriException;
use Mchljams\Chicagotransit\Exceptions\ControllerOutputTypeKeyException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class ControllerTest extends TestCase
{
    private $apiKey;

    private $mockHandler;
    
    private $controller;

    private $reflection;

    protected function setUp(): void
    {
        parent::setUp();
        // create random keys
        $this->apiKey = $this->faker->password;

        $this->mockHandler = new MockHandler();

        // instantiate the guzzle client with the mock handler
        $client = new Client([
            'handler' => $this->mockHandler,
        ]);

        $this->controller = new Controller($this->apiKey, $client);

        $reflection = new \ReflectionClass(get_class($this->controller));

        $this->reflection = $reflection;
    }
 
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->apiKey = null;
        $this->controller = null;
    }

    public function testGetRequestUri()
    {

        $fakeUri = 'http://www.lorem.com';

        $parsedFakeUri = parse_url($fakeUri);
        
        $reflectionBaseUriProperty = $this->reflection->getProperty('baseUri');
        $reflectionBaseUriProperty->setAccessible(true);
        $reflectionBaseUriProperty->setValue($this->controller,$fakeUri);

        $fakeOutputTypeKey = $this->faker->word;
        $reflectionOutputTypeKeyProperty = $this->reflection->getProperty('outputTypeKey');
        $reflectionOutputTypeKeyProperty->setAccessible(true);
        $reflectionOutputTypeKeyProperty->setValue($this->controller,$fakeOutputTypeKey);

        $path = '/endpoint';

        $params = [
            'foo' => 'bar',
            'bar' => 'baz'
        ];

        $method = $this->reflection->getMethod('getRequestUri');

        $method->setAccessible(true);

        $uri = $method->invokeArgs($this->controller, [$path, $params]);

        $parsedUri = parse_url($uri);

        parse_str($parsedUri['query'], $parsedQueryString);

        $this->assertEquals($parsedFakeUri['host'], $parsedUri['host']);
        $this->assertEquals($path , $parsedUri['path']);
        $this->assertEquals($parsedQueryString['key'], $this->apiKey);
        $this->assertTrue(array_key_exists($fakeOutputTypeKey, $parsedQueryString));
        $this->assertTrue(count(array_diff($params, $parsedQueryString)) == 0);
    }

    public function testGetBaseUri()
    {
        $fakeUri = $this->faker->url;
        $reflectionBaseUriProperty = $this->reflection->getProperty('baseUri');
        $reflectionBaseUriProperty->setAccessible(true);
        $reflectionBaseUriProperty->setValue($this->controller,$fakeUri);

        $method = $this->reflection->getMethod('getBaseUri');
        $method->setAccessible(true);
    
        $uri = $method->invoke($this->controller);

        $this->assertEquals($uri,$fakeUri);
    }

    public function testGetBaseUriException()
    {
        $this->expectException(ControllerBaseUriException::class);

        $method = $this->reflection->getMethod('getBaseUri');
        $method->setAccessible(true);
        $method->invoke($this->controller);

    }

    public function testGetOutputTypeKey()
    {
        $fakeOutputTypeKey = $this->faker->word;
        $reflectionOutputTypeKeyProperty = $this->reflection->getProperty('outputTypeKey');
        $reflectionOutputTypeKeyProperty->setAccessible(true);
        $reflectionOutputTypeKeyProperty->setValue($this->controller,$fakeOutputTypeKey);

        $method = $this->reflection->getMethod('getOutputTypeKey');
        $method->setAccessible(true);
    
        $outputTypeKey = $method->invoke($this->controller);

        $this->assertEquals($outputTypeKey,$fakeOutputTypeKey);
    }

    public function testGetOutputTypeKeyException()
    {
        $this->expectException(ControllerOutputTypeKeyException::class);
        
        $method = $this->reflection->getMethod('getOutputTypeKey');
        $method->setAccessible(true);
        $method->invoke($this->controller);

    }

    public function testGet()
    {
        $controllerGetSuccessFixture = file_get_contents(__DIR__ . '/Fixtures/controllerGetSuccessFixture.json');

        $this->mockHandler->append(new Response(200, [], $controllerGetSuccessFixture));

        $fakeUri = 'http://www.lorem.com';
        
        $reflectionBaseUriProperty = $this->reflection->getProperty('baseUri');
        $reflectionBaseUriProperty->setAccessible(true);
        $reflectionBaseUriProperty->setValue($this->controller,$fakeUri);

        $fakeOutputTypeKey = $this->faker->word;
        $reflectionOutputTypeKeyProperty = $this->reflection->getProperty('outputTypeKey');
        $reflectionOutputTypeKeyProperty->setAccessible(true);
        $reflectionOutputTypeKeyProperty->setValue($this->controller,$fakeOutputTypeKey);

        $method = $this->reflection->getMethod('get');
        $method->setAccessible(true);

        $result = $method->invokeArgs($this->controller, ['/endpoint']);

        $this->assertEquals($result, $controllerGetSuccessFixture);
    }
}