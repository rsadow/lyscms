<?php

namespace Lys\Cms\Controllers;


use Illuminate\Routing\Controller;
use Lys\Cms\Core\Theme;
use Lys\Cms\Models\Path;
use Lys\Cms\Models\Page;
use Lys\Cms\Repos\Page\PageRepository;
use Lys\Cms\Repos\Path\PathRepository;
use \Request;

class RouteController extends Controller{

    private $theme;
    private $pageRepository;
    private $pathRepository;

    function __construct(Theme $theme, PageRepository $pageRepository, PathRepository $pathRepository)
    {
        $this->theme = $theme;
        $this->pageRepository = $pageRepository;
        $this->pathRepository = $pathRepository;
    }

    public function route()
    {
        $requestUrl = Request::path();

        if ($this->isRequestHomePage($requestUrl))
        {
            $page = $this->pageRepository->findHomePage();
            if( is_null( $page ))
            {
                return $this->theme->render404();
            }
        }
        else
        {
            $page = $this->pathRepository->findEntityByUrl( $requestUrl );
            if ( is_null($page))
            {
                return $this->theme->render404();
            }
        }
        return $this->theme->render($page);
    }

    /**
     * @param $requestUrl
     * @return bool
     */
    private function isRequestHomePage($requestUrl)
    {
        return $requestUrl == "/" || $requestUrl == "index" ;
    }
} 