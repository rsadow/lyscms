<?php

namespace Lys\Cms\Models;


class Page extends \Eloquent implements Entity {

    protected $fillable = ['name', 'view', 'home'];

    public function path()
    {
        return $this->morphOne('Path', 'entity', 'entity_type', 'entity_id');
    }

    public function isPage()
    {
       return true;
    }

    public function getTitle()
    {
        return $this->name;
    }
}