<?php

namespace Gpupo\Tests\Cache;

use Gpupo\Tests\TestCaseAbstract;
use Gpupo\Cache\CacheItemPool;
use Gpupo\Cache\CacheItem;

class CacheItemPoolTest extends TestCaseAbstract
{
    public function testContemDriverApc()
    {
        $pool = new CacheItemPool('Apc');
        $this->assertInstanceOf('\Psr\Cache\CacheItemPoolInterface', $pool); 
        $this->assertInstanceOf('\Gpupo\Cache\Driver\ApcDriver', $pool->getDriver()); 
        $this->assertInstanceOf('\Gpupo\Cache\Driver\DriverInterface', $pool->getDriver()); 

    }

    public function testGravaItem()
    {
        $pool = new CacheItemPool('Apc');
        $item = new CacheItem('foo');
        $item->set('bar', 60);

        $this->assertTrue($pool->save($item));

        $restored = $pool->getItem('foo');
        $this->assertEquals('bar', $restored->get());
    }
}
