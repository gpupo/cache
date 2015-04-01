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

use Gpupo\Cache\Driver\ApcDriver;
use Gpupo\Tests\Cache\TestCaseAbstract;

class ApcDriverTest extends TestCaseAbstract
{
    protected function setUp()
    {
        if (!(extension_loaded('apc') && ini_get('apc.enabled'))) {
            $this->markTestSkipped('The APC extension is not available.');
        }

        if (!ini_get('apc.enable_cli')) {
            $this->markTestSkipped('APC CLI disabled.');
        }
    }

    public function testArmazenaInformacao()
    {
        $cacheId = 'foo';
        $value = 'bar';
        $driver = ApcDriver::getInstance();
        $driver->save($cacheId, $value, 60);
        $this->assertEquals('bar', $driver->get($cacheId));
    }

    public function testPossuiOpcoesPersonalizadas()
    {
        $driver = ApcDriver::getInstance();
        $driver->setOptions(['foo' => 'bar']);
        $this->assertEquals('bar', $driver->getOptions()->get('foo'));
    }
    /**
     * @dataProvider dataProviderObjects
     */
    public function testArmazenaObjeto($object)
    {
        $driver = ApcDriver::getInstance();
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
}
