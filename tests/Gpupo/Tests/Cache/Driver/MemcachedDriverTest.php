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

use Gpupo\Cache\Driver\MemcachedDriver;
use Gpupo\Tests\TestCaseAbstract;
use Memcached;

class MemcachedDriverTest extends TestCaseAbstract
{
    protected function factoryDriver()
    {
        $driver = MemcachedDriver::getInstance();
        $endpoint = $this->getConstant('MEMCACHED_SERVER', 'localhost');
        $driver->setOptions(['serverEndPoint' => $endpoint]);

        return $driver;
    }
    public function testPossuiClientMemcached()
    {
        $this->assertInstanceOf('\Memcached', MemcachedDriver::getInstance()->getClient());
    }

    public function testArmazenaInformacao()
    {
        $cacheId = 'foo';
        $value = 'bar';
        $driver = $this->factoryDriver();
        $this->assertTrue($driver->save($cacheId, $value, 60));
        $this->assertEquals('bar', $driver->get($cacheId));
    }

    public function testPossuiOpcoesPersonalizadas()
    {
        $driver = $this->factoryDriver();
        $driver->setOptions(['foo' => 'bar']);
        $this->assertEquals('bar', $driver->getOptions()->get('foo'));
    }
    /**
     * @dataProvider dataProviderObjects
     */
    public function testArmazenaObjeto($object)
    {
        $driver = $this->factoryDriver();
        $cacheId = $driver->generateId($object);
        $driver->save($cacheId, $object, 60);
        $this->assertEquals($object, $driver->get($cacheId));
    }

    public function dataProviderObjects()
    {
        $data = array();

        $i = 0;
        while ($i < 5) {
            $data[] = array('data' => $data, 'new' => new \ArrayObject());
            $i++;
        }

        return $data;
    }

    protected function setUp()
    {
        if (!class_exists('Memcached')) {
            $this->markTestSkipped('The Memcached extension is not available.');
        }
    }
}
