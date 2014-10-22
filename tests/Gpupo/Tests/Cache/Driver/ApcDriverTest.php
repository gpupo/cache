<?php

namespace Gpupo\Tests\Cache\Driver;

use Gpupo\Tests\TestCaseAbstract;
use Gpupo\Cache\Driver\ApcDriver;

class ApcDriverTest extends TestCaseAbstract
{
    public function testArmazenaInformacao()
    {
        $cacheId = 'foo';
        $value = 'bar';
        $driver = ApcDriver::getInstance(); 
        $driver->save($cacheId, $value);
        $this->assertEquals('bar', $driver->get($cacheId));
    }
    
    /**
     * @dataProvider dataProviderObjects
     */
    public function testArmazenaObjeto($object)
    {
        $driver = ApcDriver::getInstance(); 
        $cacheId = $driver->generateId($object);
        $driver->save($cacheId, $object);
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
  
    protected function setUp()
    {
        if (!(extension_loaded('apc') && ini_get('apc.enabled'))) {
            $this->markTestSkipped('The APC extension is not available.');
        }
        
        if (!ini_get('apc.enable_cli')) {
            $this->markTestSkipped('APC CLI disabled.');
        }
    }

}
