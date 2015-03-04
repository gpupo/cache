<?php

namespace Gpupo\Cache\Driver;

use Memcached;

class MemcachedDriver extends DriverAbstract implements DriverInterface
{
    private $client;
    
    public function getClient()
    {
        if (!$this->client) {
            $client = new Memcached;
            $client->addServer(
                $this->getOptions()->get('serverEndPoint', 'localhost'),
                $this->getOptions()->get('serverPort', 11211));
            $this->setClient($client);
        }
        
        return $this->client;
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

        $obj = $this->serialize($obj, $serialize);
       
       var_dump(
       [
        'id' => $id,
        'obj' => $obj,
        'ttl' => $ttl,
        'options' => $this->getOptions()->toArray(),
       ]
       );
        
        return $this->getClient()->set($id, $obj, $ttl);
    }

    public function get($id, $unserialize = true)
    {
        if (!$this->isSupported()) {
            return false;
        }

        $obj =  $this->getClient()->get($id);

        return $this->unserialize($obj, $unserialize);
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
