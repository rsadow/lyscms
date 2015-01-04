<?php

namespace Lys\Cms\Repos\Page;


use Lys\Cms\Models\Page;
use Lys\Cms\Repos\DbRepository;

class DbPageRepository extends DbRepository implements PageRepository {


    /**
     * @var Page
     */
    protected $model;

    function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function findHomePage()
    {
        $page = Page::whereHome(1)->first();
        return $page;
    }
}