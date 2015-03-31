<?php

namespace Gpupo\Tests\Cache\Driver;

use Gpupo\Tests\TestCaseAbstract;
use Gpupo\Cache\Driver\MemcachedDriver;
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
        $mem->addServer($this->getConstant('MEMCACHED_SERVER', 'localhost'), 11211);
        $stats = $mem->getStats();
        if (!isset($stats[$this->getConstant('MEMCACHED_SERVER', 'localhost').':11211'])) {
            $this->markTestSkipped('The Memcached server is not running.');
        }
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
            $data[] = array('data' =>  $data, 'new' => new \ArrayObject);
            $i++;
        }
        
        return $data;
    }

    protected function factoryDriver()
    {
        $driver = MemcachedDriver::getInstance();
        $endpoint = $this->getConstant('MEMCACHED_SERVER', 'localhost');
        $driver->setOptions(['serverEndPoint' => $endpoint]);

        return $driver;
    }
}
