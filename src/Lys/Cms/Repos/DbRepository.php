<?php

namespace Lys\Cms\Repos;


abstract class DbRepository {

    public function create($params)
    {
        return $this->model->create($params);
    }

    public function fill($params)
    {
        return $this->model->fill($params);
    }
} 