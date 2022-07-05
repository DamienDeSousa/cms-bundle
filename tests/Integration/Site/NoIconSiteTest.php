<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Site;

use Dades\CmsBundle\DataFixtures\ORM\Site\NoIconSiteTextFixture;
use Dades\CmsBundle\Entity\Site;
use Dades\TestFixtures\Fixture\FixtureAttachedTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NoIconSiteTest extends KernelTestCase
{
    use FixtureAttachedTrait {
        FixtureAttachedTrait::setUp as setUpTrait;
    }

    private \Twig\Environment $twig;

    protected static function getFixtureNameForTestCase(string $testCaseName): string
    {
        return NoIconSiteTextFixture::class;
    }

    protected function setUp(): void
    {
        $this->setUpTrait();
        self::bootKernel();
        $this->twig = self::$kernel->getContainer()->get('test.service_container')->get('twig');
    }

    public function testGetEmptyIconFromSite()
    {
        $twigGetIconFunction = $this->twig->getFunction('get_icon');
        $getIcon = $twigGetIconFunction->getCallable();

        $this->assertNull($getIcon());
    }
}
