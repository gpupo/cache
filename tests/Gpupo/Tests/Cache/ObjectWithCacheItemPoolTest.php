<?php

namespace Gpupo\Tests\Cache;

use Gpupo\Tests\TestCaseAbstract;
use Gpupo\Cache\CacheItemPool;
use Gpupo\Example\ObjectWithCacheItemPool;

class ObjectWithCacheItemPoolTest extends TestCaseAbstract
{
    public function testGravaItem()
    {
        $pool = new CacheItemPool('Apc');
        $object = new ObjectWithCacheItemPool;
        $object->setCacheItemPool($pool); 
        $this->assertInstanceOf('\Psr\Cache\CacheItemPoolInterface', $object->getCacheItemPool()); 
        $this->assertInstanceOf('\Gpupo\Cache\Driver\ApcDriver', $object->getCacheItemPool()->getDriver()); 
        $this->assertInstanceOf('\Gpupo\Cache\Driver\DriverInterface', $object->getCacheItemPool()->getDriver()); 
    }
}
