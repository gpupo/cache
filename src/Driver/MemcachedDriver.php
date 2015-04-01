<?php

/*
 * This file is part of gpupo\cache
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Cache\Driver;

use Memcached;

class MemcachedDriver extends DriverAbstract implements DriverInterface
{
    private $client;

    public function getClient()
    {
        if (!$this->client) {
            $client = new Memcached();
            $client->addServer(
                $this->getOptions()->get('serverEndPoint', 'localhost'),
                $this->getOptions()->get('serverPort', 11211));
            $this->setClient($client);
        }

        return $this->client;
    }

    protected function giveUp()
    {
        throw new \RuntimeException('I can not do it for you, Charlie!('
            .$this->getClient()->getResultMessage().')', $this->getClient()->getResultCode());
    }

    public function setClient(Memcached $client)
    {
        $this->client = $client;

        return $this;
    }

    public function save($id, $obj, $ttl, $serialize = true)
    {
        if (!$this->isSupported()) {
            return false;
        }

        $string = $this->serialize($obj, $serialize);

        $op = $this->getClient()->set($id, $string, $ttl);

        if (!$op) {
            $this->giveUp();
        }

        return $op;
    }

    public function get($id, $unserialize = true)
    {
        if (!$this->isSupported()) {
            return false;
        }

        $string =  $this->getClient()->get($id);

        $obj = $this->unserialize($string, $unserialize);

        return $obj;
    }

    public function delete($id)
    {
        if (!$this->isSupported()) {
            return false;
        }

        return $this->getClient()->delete($id);
    }

    public function isSupported()
    {
        return class_exists('Memcached');
    }
}
