<?php

namespace Lys\Cms\Core;

use Lys\Cms\Models\Entity;
use Symfony\Component\Finder\Finder;


class ThemeViewFinder {

    protected $custom;
    protected $root;
    protected $viewCache;

    const VIEW_EXT = '.blade.php';

    function __construct($root)
    {
        $this->root = $root;
    }

    public function getThemeFile(Entity $entity)
    {
        $this->viewCache =  iterator_to_array(Finder::create()
            ->in($this->root)
            ->files()
            ->depth('<= 1')
            ->name('*'.self::VIEW_EXT));

        if(     $entity->isPage() && $view = $this->getCustomView($entity) ) :
        elseif( $entity->isPage() && $view = $this->getPageView($entity) ) :
        else:
                $view = $this->getIndexView();
        endif;

        return $view;
    }

    /**
     * @param $type
     * @param array $views
     * @return string
     */
    private function getView($type, $views = [])
    {
        $type = preg_replace( '|[^a-z0-9-]+|', '', $type );

        if ( empty( $views ) )
            $views = array($type.self::VIEW_EXT);

        $match = '';
        foreach ($views as $view)
        {
            $match = $this->findViewInCache($view);
            if($match) break;
        }

        return $match;
    }

    /**
     * @param Entity $entity
     * @return string
     */
    private function getPageView(Entity $entity)
    {
        $viewName = 'page';

        $id = $entity->id;
        $slug = $entity->name;
        $home = $entity->home;

        $views = [];
        if($home) $views = $this->addView("home");
        $views+= $this->addView(["$viewName-$slug", "$viewName-$id", $viewName]);

        return $this->getView($viewName, $views);
    }

    private function getIndexView()
    {
        return $this->getView('index');
    }

    private function getCustomView(Entity $entity)
    {
        if($entity->view)
        {
            $views = $this->addView($entity->view);
            return $this->getView('page', $views);
        }
        return null;
    }

    /**
     * @param $view
     * @return mixed
     */
    private function findViewInCache($view)
    {
        $match = '';
        foreach ($this->viewCache as $cache)
        {
            if ($cache->getFilename() == $view)
            {
                $match = $cache->getRelativePathname();
                break;
            }
        }

        return $match;
    }

    private function addView($view)
    {
        if(!is_array($view)) $view = [$view];

        array_walk($view, function(&$element){
            $element.=self::VIEW_EXT;
        });

        return $view;
    }
} 