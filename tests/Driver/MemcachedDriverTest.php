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
use Gpupo\Tests\Cache\TestCaseAbstract;
use Memcached;

class MemcachedDriverTest extends TestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();
        if (!class_exists('Memcached')) {
            $this->markTestSkipped('The Memcached extension is not available.');
        }
        $mem = new Memcached();
        $endpoint = $this->getConstant('MEMCACHED_SERVER', 'localhost');
        $mem->addServer($endpoint, 11211);
        $stats = $mem->getStats();

        if (!isset($stats[$endpoint.':11211'])) {
            $this->markTestSkipped('The Memcached server is not running.');
        }
    }

    protected function factoryDriver()
    {
        $driver = MemcachedDriver::getInstance();
        $endpoint = $this->getConstant('MEMCACHED_SERVER', 'localhost');
        $driver->setOptions(['serverEndPoint' => $endpoint]);

        return $driver;
    }
    public function testPossuiClientMemcached()
    {
        $this->assertInstanceOf('\Gpupo\Cache\Driver\MemcachedDriver', MemcachedDriver::getInstance());
        $this->assertInstanceOf('\Memcached', MemcachedDriver::getInstance()->getClient());
    }

    public function testArmazenaInformacao()
    {
        $id = 'foo';
        $value = 'bar';
        $driver = $this->factoryDriver();

        try {
            $this->assertTrue($driver->save($id, $value, 60));
            $this->assertEquals('bar', $driver->get($id));
        } catch (\RuntimeException $e) {
            if ($e->getCode() === 47) {
                $this->markTestSkipped($e->getMessage());
            }
        }
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
    public function testArmazenaObjeto($id, $object)
    {
        $driver = $this->factoryDriver();

        try {
            $this->assertTrue($driver->save($id, $object, 60));
            $this->assertEquals($object, $driver->get($id));
        } catch (\RuntimeException $e) {
            if ($e->getCode() === 47) {
                $this->markTestSkipped($e->getMessage());
            }
        }
    }

    public function dataProviderObjects()
    {
        return [
            ['array-123', [1,2,3]],
        ];
    }
}
