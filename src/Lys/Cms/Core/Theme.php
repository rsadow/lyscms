<?php

namespace Lys\Cms\Core;


use Illuminate\Support\Facades\Config;
use Lys\Cms\Models\Entity;

class Theme {

    protected $theme;

    function __construct()
    {
        $this->theme = Config::get('cms.theme');
    }

    public function render(Entity $page)
    {
        return $this->createView("index", ['page' => $page]);
    }

    public function render404()
    {
        return \Response::make('Unauthorized', 404);
    }

    private function createView($name, $params = [])
    {
        return \View::make("lys.cms::{$name}", $params);
    }

}

/*
 *
 *  Page -> custom.blade.php -> page-$slug$.blade.php -> page-$id$.blade.php -> index.blade.php
 *  Article -> article-$type$.blade.php -> article.blade.php -> index.blade.php
 *
 *  HomePage -> home.blade.php -> Page
 *
 *
 */