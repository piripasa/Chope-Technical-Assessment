<?php


namespace App\Repository;


use App\Service\Cache\CacheInterface;

class ActivityRepository implements CacheRepositoryInterface
{
    private $model;

    /**
     * ActivityRepository constructor.
     * @param CacheInterface $model
     */
    public function __construct(CacheInterface $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $key
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    public function findBy(string $key, int $offset = 0, int $limit = -1)
    {
        return $this->model->getList($key, $offset, $limit);
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $score
     * @return mixed
     */
    public function store(string $key, string $value, int $score = 1)
    {
        return $this->model->addToList($key, $value, $score);
    }
}
