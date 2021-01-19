<?php


namespace App\Repository;


use App\Models\User;

class UserRepository implements RepositoryInterface
{
    private $model;

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = ['*'])
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function store(array $params)
    {
        return $this->model->create($params);
    }
}
