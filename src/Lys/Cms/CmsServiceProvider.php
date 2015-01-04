<?php namespace Lys\Cms;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Lys\Cms\Repos\Page\PageRepository', 'Lys\Cms\Repos\Page\DbPageRepository');
        $this->app->bind('Lys\Cms\Repos\Path\PathRepository', 'Lys\Cms\Repos\Path\DbPathRepository');
    }

    public function boot()
    {
        $this->package('lys/cms', 'lys.cms');
        \View::addNamespace('lys.cms', \Config::get('cms.theme_path') . \Config::get('cms.theme'));

        include __DIR__ . '/routes.php';
    }
}
?>