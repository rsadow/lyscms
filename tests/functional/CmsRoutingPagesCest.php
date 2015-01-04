<?php
use \FunctionalTester;

class CmsRoutingPagesCest
{
    public function _before(FunctionalTester $I)
    {
        Artisan::call('migrate', ['--path' => 'src/Lys/migrations']);
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function it_route_to_a_page(FunctionalTester $I)
    {
        $I->am("guest user");
        $I->wantTo("route to a page");

        $I->havePageUrl(['name' => 'blog'], ['url' => 'blog']);

        $I->amOnPage('/blog');
        $I->canSeeInTitle('blog');
    }

    public function it_route_to_home_page(FunctionalTester $I)
    {
        $I->am("guest user");
        $I->wantTo("route to a home page");

        $I->havePageUrl(['name' => 'home', 'home' => 1], ['url' => 'home']);

        $I->amOnPage('/');
        $I->canSeeInTitle('home');
    }

    public function it_route_to_404_page(FunctionalTester $I)
    {
        $I->am("guest user");
        $I->wantTo("route to 404 page");

        $I->havePageUrl(['name' => 'home'], ['url' => '/']);

        $I->amOnPage('/this_page_is_not_exist');
        $I->canSeePageNotFound();
    }

    public function it_route_to_nested_page(FunctionalTester $I)
    {
        $I->am("guest user");
        $I->wantTo("route to route to nested page");

        $I->havePageUrl(['name' => 'about'], ['url' => 'about']);
        $I->havePageUrl(['name' => 'hobby'], ['url' => 'about/hobby']);

        $I->amOnPage('/about/hobby');
        $I->canSeeInTitle('hobby');
    }
}