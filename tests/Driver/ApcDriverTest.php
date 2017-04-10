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
        $this->assertSame('bar', $driver->get($cacheId));
    }

    public function testPossuiOpcoesPersonalizadas()
    {
        $driver = ApcDriver::getInstance();
        $driver->setOptions(['foo' => 'bar']);
        $this->assertSame('bar', $driver->getOptions()->get('foo'));
    }
    /**
     * @dataProvider dataProviderObjects
     */
    public function testArmazenaObjeto($object)
    {
        $driver = ApcDriver::getInstance();
        $cacheId = $driver->generateId($object);
        $driver->save($cacheId, $object, 60);
        $this->assertSame($object, $driver->get($cacheId));
    }

    public function dataProviderObjects()
    {
        $data = [];

        $i = 0;
        while ($i < 5) {
            $data[] = ['data' => $data, 'new' => new \ArrayObject()];
            ++$i;
        }

        return $data;
    }
}
