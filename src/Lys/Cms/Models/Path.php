<?php

namespace Lys\Cms\Models;


class Path extends \Eloquent {

    protected $fillable = ['entity_id','entity_type', 'url'];

    public function entity()
    {
        return $this->morphTo('entity', 'entity_type', 'entity_id')->getResults();
    }
}
