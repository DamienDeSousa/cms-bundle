<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Routing;

use Dades\CmsBundle\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RouteLoaderTestFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $page = new Page();
        $page->setUrl('/obiwan-kenobi');
        $page->setRouteName('route_name');
        $page->setTemplate('path/to/template.html.twig');
        $manager->persist($page);
        $manager->flush();
        $this->addReference('page', $page);
    }
}