<?php

namespace Mchljams\Chicagotransit\Tests\Unit\Entities;

use Mchljams\Chicagotransit\Entities\Entity;

/**
 * Describes a Route entity.
 */
class MockEntity extends Entity
{
    private $foo;
    private $bar;

    public function __construct(\stdClass $values)
    {
        parent::__construct($values);
    }

    public function setFoo(string $foo)
    {
        $this->foo = $foo;
    }

    public function getFoo()
    {
        return $this->foo;
    }

    public function setBar(string $bar)
    {
        $this->bar = $bar;
    }

    public function getBar()
    {
        return $this->bar;
    }
}