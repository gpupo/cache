<?php

namespace Gpupo\Tests\Cache\Driver;

use Gpupo\Tests\TestCaseAbstract;
use Gpupo\Cache\Driver\NullDriver;

class DriverAbstractTest extends TestCaseAbstract
{
    public function testSerializaInformacao()
    {
        $driver = NullDriver::getInstance();
        
        $array = [1,[2],[3,4]];

        $serialized = $driver->serialize($array);

        $this->assertEquals($array, $driver->unserialize($serialized));
    }
}
