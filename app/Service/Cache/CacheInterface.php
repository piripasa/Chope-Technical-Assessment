<?php

namespace App\Service\Cache;

interface CacheInterface
{
    /**
     * @param string $key
     * @param $value
     * @param int $ttl
     * @return CacheInterface
     */
    public function set(string $key, $value, $ttl = 0): CacheInterface;

    /**
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function get(string $key, $default = "");

    /**
     * @param $key
     * @return mixed
     */
    public function delete($key);
}

