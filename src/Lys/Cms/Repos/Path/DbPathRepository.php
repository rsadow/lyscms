<?php

namespace Lys\Cms\Repos\Path;


use Lys\Cms\Repos\DbRepository;
use Lys\Cms\Models\Path;

class DbPathRepository extends DbRepository implements PathRepository {

    public function findByUrl($url)
    {
        $path = Path::whereUrl($url)->first();
        return $path;
    }

    public function findEntityByUrl($url)
    {
        $path = $this->findByUrl($url);
        if( !is_null($path) )
            return $path->entity();
        else
            return null;
    }
}