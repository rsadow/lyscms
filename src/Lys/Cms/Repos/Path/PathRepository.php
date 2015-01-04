<?php
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 22.08.2014
 * Time: 21:49
 */

namespace Lys\Cms\Repos\Path;


interface PathRepository {

    public function findByUrl($url);
    public function findEntityByUrl($url);
} 