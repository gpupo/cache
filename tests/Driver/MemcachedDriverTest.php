<?php

/*
 * This file is part of gpupo/cache
 * Created by Gilmar Pupo <contact@gpupo.com>
 * For the information of copyright and license you should read the file
 * LICENSE which is distributed with this source code.
 * Para a informação dos direitos autorais e de licença você deve ler o arquivo
 * LICENSE que é distribuído com este código-fonte.
 * Para obtener la información de los derechos de autor y la licencia debe leer
 * el archivo LICENSE que se distribuye con el código fuente.
 * For more information, see <https://www.gpupo.com/>.
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
            $this->assertSame('bar', $driver->get($id));
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
        $this->assertSame('bar', $driver->getOptions()->get('foo'));
    }
    /**
     * @dataProvider dataProviderObjects
     */
    public function testArmazenaObjeto($id, $object)
    {
        $driver = $this->factoryDriver();

        try {
            $this->assertTrue($driver->save($id, $object, 60));
            $this->assertSame($object, $driver->get($id));
        } catch (\RuntimeException $e) {
            if ($e->getCode() === 47) {
                $this->markTestSkipped($e->getMessage());
            }
        }
    }

    public function dataProviderObjects()
    {
        return [
            ['array-123', [1, 2, 3]],
        ];
    }
}
