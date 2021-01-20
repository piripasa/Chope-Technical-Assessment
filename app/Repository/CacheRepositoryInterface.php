<?php


namespace App\Repository;


interface CacheRepositoryInterface
{
    /**
     * @param string $key
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    public function findBy(string $key, int $offset = 0, int $limit = -1);

    /**
     * @param string $key
     * @param string $value
     * @param int $score
     * @return mixed
     */
    public function store(string $key, string $value, int $score = 1);
}
