<?php

namespace Mchljams\Chicagotransit\Tests\Unit;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use Faker\Factory;

class TestCase extends PhpUnitTestCase
{
    protected $faker;

    protected function setUp(): void
    {
        // Set the Client configurations
        $this->faker = Factory::create();
    }
 
    protected function tearDown(): void
    {
        $this->faker = null;
    }
}