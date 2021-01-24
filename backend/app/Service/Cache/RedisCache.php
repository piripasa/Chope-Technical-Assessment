<?php

namespace App\Service\Cache;

use Illuminate\Redis\Connections\PredisConnection;

class RedisCache implements CacheInterface
{

    private $client;

    public function __construct(PredisConnection $client)
    {
        $this->client = $client;
    }

    /**
     * Set Value in Redis Cache
     *
     * @param string $key
     * @param mixed $value
     * @param int $ttl - Expire Time in second
     *
     * @return CacheInterface $this
     */
    public function set(string $key, $value, $ttl = 0): CacheInterface
    {
        $this->client->set($key, $value);

        if ($ttl > 0) {
            $this->client->expire($key, $ttl);
        }

        return $this;
    }

    /**
     * Get value from Redis
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed $value
     */
    public function get(string $key, $default = "")
    {
        $val = $this->client->get($key);
        if (empty($val)) {
            return $default;
        }
        return $val;
    }

    /**
     * Get particular key or multiple keys
     *
     * @param string|pattern|array $key
     *
     * @return bool true
     */
    public function delete($key)
    {
        if (is_string($key) && strpos($key, "*") !== false) {
            $keys = array_map(function ($key) {
                return explode(":", $key)[1];
            }, $this->client->keys($key));
        } else {
            $keys = $key;
        }

        if (!empty($keys)) {
            return $this->client->del($keys);
        }
    }

    public function addToList(string $key, $value, int $score): CacheInterface
    {
        $this->client->zadd($key, $score, $value);

        return $this;
    }

    public function getList(string $key, int $from = 0, int $to = -1)
    {
        return $this->client->zrange($key, $from, $to);
    }
}
