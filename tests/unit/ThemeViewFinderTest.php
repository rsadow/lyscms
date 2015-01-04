<?php


use Lys\Cms\Core\ThemeViewFinder;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamContent;
use org\bovigo\vfs\vfsStreamFile;

class ThemeViewFinderTest extends \Codeception\TestCase\Test
{
   /**
    * @var \UnitTester
    */
    protected $tester;
    protected $sut;
    protected $root;
    protected $pageRepository;


    protected function _before()
    {
        $structure = array(
                'layouts' => array(
                    'default.blade.php' => '',
                    'special.blade.php' => '',
                ),
                'partials' => array(
                    'header.blade.php' => '',
                    'footer.blade.php' => '',
                ),
                'index.blade.php' => '',
                'page.blade.php' => ''

        );
        $this->root = vfsStream::setup('root', null, $structure);
        $this->sut = new ThemeViewFinder($this->root->url());
        $this->pageRepository = App::make('Lys\Cms\Repos\Page\DbPageRepository');
    }

    protected function _after()
    {
    }

    /** @testn */
    public function it_get_page_template_for_page_entity()
    {
        $page = $this->pageRepository->fill(['name' => 'home']);
        $file = $this->sut->getThemeFile($page);

        $this->assertEquals($file, 'page.blade.php');
    }

    /** @testn */
    public function it_get_index_template_for_page_entity()
    {
        $this->root->removeChild('page.blade.php');
        $page = $this->pageRepository->fill(['name' => 'home']);
        $file = $this->sut->getThemeFile($page);

        $this->assertEquals($file, 'index.blade.php');
    }

    /** @test */
    public function it_get_id_template_for_page_entity()
    {
        $this->root->addChild(vfsStream::newFile('page-5.blade.php'));
        $page = $this->pageRepository->fill(['name' => 'home']);
        $page->id = 5;
        $file = $this->sut->getThemeFile($page);

        $this->assertEquals($file, 'page-5.blade.php');
    }

    /** @test */
    public function it_get_slug_template_for_page_entity()
    {
        $this->root->addChild(vfsStream::newFile('page-5.blade.php'));
        $this->root->addChild(vfsStream::newFile('page-home.blade.php'));
        $page = $this->pageRepository->fill(['name' => 'home']);
        $page->id = 5;
        $file = $this->sut->getThemeFile($page);

        $this->assertEquals($file, 'page-home.blade.php');
    }


    /** @test */
    public function it_get_custom_template_for_page_entity()
    {
        $this->root->addChild(vfsStream::newFile('page-5.blade.php'));
        $this->root->addChild(vfsStream::newFile('page-home.blade.php'));
        $this->root->addChild(vfsStream::newFile('custom-view.blade.php'));

        $page = $this->pageRepository->fill(['name' => 'home', 'view' => 'custom-view' ]);
        $page->id = 5;
        $file = $this->sut->getThemeFile($page);
        $this->assertEquals($file, 'custom-view.blade.php');
    }

    /** @test */
    public function it_get_home_template_for_page_entity()
    {
        $this->root->addChild(vfsStream::newFile('page-5.blade.php'));
        $this->root->addChild(vfsStream::newFile('page-blog.blade.php'));
        $this->root->addChild(vfsStream::newFile('custom-view.blade.php'));
        $this->root->addChild(vfsStream::newFile('home.blade.php'));
        $page = $this->pageRepository->fill(['name' => 'home', 'home' => 1 ]);
        $page->id = 5;

        $file = $this->sut->getThemeFile($page);

        $this->assertEquals($file, 'home.blade.php');
    }


}