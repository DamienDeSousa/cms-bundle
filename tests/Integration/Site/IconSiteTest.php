<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Site;

use Dades\CmsBundle\Entity\Site;
use Dades\CmsBundle\Twig\Admin\AdminExtension;
use Dades\TestFixtures\Fixture\FixtureAttachedTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IconSiteTest extends KernelTestCase
{
    use FixtureAttachedTrait {
        FixtureAttachedTrait::setUp as setUpTrait;
    }

    private \Twig\Environment $twig;

    private string $uploadPathDir;

    protected static function getFixtureNameForTestCase(string $testCaseName): string
    {
        return \Dades\CmsBundle\DataFixtures\ORM\Site\IconSiteTest::class;
    }

    protected function setUp(): void
    {
        $this->setUpTrait();
        self::bootKernel();
        $this->twig = self::$kernel->getContainer()->get('test.service_container')->get('twig');
        $this->uploadPathDir = self::$kernel->getContainer()->getParameter('dades_cms.icon_directory');
    }

    public function testGetIcon()
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        $twigGetIconFunction = $this->twig->getFunction('get_icon');
        $getIcon = $twigGetIconFunction->getCallable();

        $this->assertEquals($this->uploadPathDir . $site->getIcon(), $getIcon());
    }
}