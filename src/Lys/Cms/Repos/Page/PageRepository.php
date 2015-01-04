<?php

namespace Lys\Cms\Repos\Page;


interface PageRepository {

    public function findHomePage();
    public function create($params);
    public function fill($params);
} 