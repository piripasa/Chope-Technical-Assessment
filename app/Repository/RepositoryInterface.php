<?php


namespace App\Repository;


interface RepositoryInterface
{
    /**
     * @param string $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy(string $attribute, $value, array $columns = ['*']);

    /**
     * @param array $params
     * @return mixed
     */
    public function store(array $params);
}
