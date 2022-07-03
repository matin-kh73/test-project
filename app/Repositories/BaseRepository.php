<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\{
    Builder,
    Model
};

abstract class BaseRepository
{
    /**
     * @var Builder
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model->newQuery();
    }

    /**
     * @param int $id
     *
     * @return Model
     */
    public function find(int $id): Model
    {
        return $this->model->find($id);
    }
}
