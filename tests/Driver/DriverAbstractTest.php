<?php

/*
 * This file is part of gpupo\cache
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Tests\Cache\Driver;

use Gpupo\Cache\Driver\NullDriver;
use Gpupo\Tests\Cache\TestCaseAbstract;

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
