<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Laracasts\TestDummy\Factory;

class FunctionalHelper extends \Codeception\Module
{

    public function havePageUrl($pageAttributes = [], $urlAttributes = [])
    {
        $page = Factory::create('Lys\Cms\Models\Page', $pageAttributes);
        $this->createUrl($page, $urlAttributes);
    }

    private function createUrl($entity, $urlAttributes = [])
    {
        $relationAttributes = [
            'entity_id' => $entity->id,
            'entity_type' => get_class($entity)
        ];
        $url = Factory::create('Lys\Cms\Models\Path', array_merge($relationAttributes, $urlAttributes));
        return $url;
    }
}