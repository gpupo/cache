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

use Gpupo\Cache\CacheItem;
use Gpupo\Cache\CacheItemPool;
use Gpupo\Tests\Cache\TestCaseAbstract;

class CacheItemPoolTest extends TestCaseAbstract
{
    public function testContemDriverApc()
    {
        $pool = new CacheItemPool('Apc');
        $this->assertInstanceOf('\Psr\Cache\CacheItemPoolInterface', $pool);
        $this->assertInstanceOf('\Gpupo\Cache\Driver\ApcDriver', $pool->getDriver());
        $this->assertInstanceOf('\Gpupo\Cache\Driver\DriverInterface', $pool->getDriver());
    }

    /**
     * @dataProvider dataProviderItens
     */
    public function testGravaItem($key, $value)
    {
        $pool = new CacheItemPool('Apc');
        $item = new CacheItem($key);
        $item->set($value, 60);
        $this->assertTrue($pool->save($item));
        $restored = $pool->getItem($key);        
        $this->assertEquals($value, $restored->get());
    }
    
    public function dataProviderItens()
    {
        return [
            ['foo', 'bar'],
            ['array', [1,2,3]],
            ['array', [1,'x' => 'y',3]],
        ];
    }
}
