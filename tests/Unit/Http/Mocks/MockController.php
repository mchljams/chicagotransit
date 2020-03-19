<?php

namespace Mchljams\Chicagotransit\Tests\Unit\Http\Mocks;

use Mchljams\Chicagotransit\Http\Controller;

/**
 * Describes a Route entity.
 */
class MockController extends Controller
{
    public function mockEndpoint()
    {
        return [];
    }
}