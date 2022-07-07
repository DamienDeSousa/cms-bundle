<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Site;
use Dades\CmsBundle\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NoIconSiteTextFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $site = new Site();
        $site->setTitle('Star Wars');
        $manager->persist($site);
        $manager->flush();
        $this->addReference('site', $site);
    }
}