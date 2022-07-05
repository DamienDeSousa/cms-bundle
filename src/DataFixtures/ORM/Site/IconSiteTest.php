<?php

declare(strict_types=1);

namespace Dades\CmsBundle\DataFixtures\ORM\Site;

use Dades\CmsBundle\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IconSiteTest extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $site = new Site();
        $site->setTitle('Star Wars');
        $site->setIcon('path/to/icon.png');
        $manager->persist($site);
        $manager->flush();
        $this->addReference('site', $site);
    }
}