<?php

namespace Mchljams\Chicagotransit\Tests\Unit\Http;

use Mchljams\Chicagotransit\Tests\Unit\TestCase;
use Mchljams\Chicagotransit\Tests\Unit\Entities\MockEntity;
use Mchljams\Chicagotransit\Http\Results;


class ResultsTest extends TestCase
{
    private $entity;

    private $results;
 
    protected function setUp(): void
    {

        $sampleData = ['foo' => 'bar', 'bar' => 'baz'];
        $sampleDataObject = (object) $sampleData;


        $this->entity = new MockEntity($sampleDataObject);

        $this->results = new Results($this->entity);
    }
 
    protected function tearDown(): void
    {
        $this->entity = null;

        $this->results = null;
    }

    public function testGetIterator()
    {
        $this->results->add($this->entity);

        $this->assertTrue($this->results->getIterator() instanceof \ArrayIterator);
    }
}