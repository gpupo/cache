<?php

/*
 * This file is part of gpupo\cache
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Tests\Cache;

use Gpupo\Cache\CacheItemPool;
use Gpupo\Example\ObjectWithCacheItemPool;

class ObjectWithCacheItemPoolTest extends TestCaseAbstract
{
    public function testContemPool()
    {
        $pool = new CacheItemPool('Apc');
        $object = new ObjectWithCacheItemPool();
        $object->setCacheItemPool($pool);
        $this->assertInstanceOf('\Psr\Cache\CacheItemPoolInterface', $object->getCacheItemPool());
        $this->assertInstanceOf('\Gpupo\Cache\Driver\ApcDriver', $object->getCacheItemPool()->getDriver());
        $this->assertInstanceOf('\Gpupo\Cache\Driver\DriverInterface', $object->getCacheItemPool()->getDriver());
    }
}
