<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Site;

use Dades\CmsBundle\DataFixtures\ORM\Site\CreateSiteCommandTestFixture;
use Dades\CmsBundle\DataFixtures\ORM\Site\DeleteSiteTestFixture;
use Dades\TestFixtures\Fixture\FixtureAttachedTrait;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DeleteSiteTest extends KernelTestCase
{
    use FixtureAttachedTrait {
        FixtureAttachedTrait::setUp as setUpTrait;
    }

    private ManagerRegistry $managerRegistry;

    protected static function getFixtureNameForTestCase(string $testCaseName): string
    {
        return DeleteSiteTestFixture::class;
    }

    protected function setUp(): void
    {
        $this->setUpTrait();
        self::bootKernel();
        $this->managerRegistry = self::$kernel->getContainer()->get('doctrine');
    }

    public function testUnableToDeleteSite()
    {
        $this->expectException(\Dades\CmsBundle\Exception\DeleteEntityException::class);
        $site = $this->fixtureRepository->getReference('site');
        $this->managerRegistry->getManager()->persist($site);
        $this->managerRegistry->getManager()->remove($site);
        $this->managerRegistry->getManager()->flush();
    }
}