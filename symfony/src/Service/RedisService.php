<?php

namespace App\Service;


use Predis\Client;

class RedisService
{
    /**
     * @var Client $client
     */
    private $client;

    /**
     * RedisService constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $key
     * @return string
     */
    public function get(string $key)
    {
        return $this->client->get($key);
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $expireTime
     */
    public function set(string $key, string $value, $expireTime = 360): void
    {
        $this->client->set($key, $value, 'EX', $expireTime);
    }

}
