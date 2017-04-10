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
