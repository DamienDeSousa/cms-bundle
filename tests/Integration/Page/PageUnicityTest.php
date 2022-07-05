<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Page;

use Dades\CmsBundle\DataFixtures\ORM\Page\PageUnicityTestFixture;
use Dades\CmsBundle\Entity\Block;
use Dades\CmsBundle\Entity\Page;
use Dades\TestFixtures\Fixture\FixtureAttachedTrait;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PageUnicityTest extends KernelTestCase
{
    use FixtureAttachedTrait {
        FixtureAttachedTrait::setUp as setUpTrait;
    }

    private ManagerRegistry $managerRegistry;

    protected static function getFixtureNameForTestCase(string $testCaseName): string
    {
        return PageUnicityTestFixture::class;
    }

    protected function setUp(): void
    {
        $this->setUpTrait();
        self::bootKernel();
        $this->managerRegistry = self::$kernel->getContainer()->get('doctrine');
    }

    public function testUnableToCreateNewPageWithSameRouteName()
    {
        $this->expectException(\Doctrine\DBAL\Exception\UniqueConstraintViolationException::class);
        /** @var Page $page */
        $page = $this->fixtureRepository->getReference('page');
        $newPage = new Page();
        $newPage->setTemplate($page->getTemplate());
        $newPage->setRouteName($page->getRouteName());
        $newPage->setUrl('new-url');
        $this->managerRegistry->getManager()->persist($newPage);
        $this->managerRegistry->getManager()->flush();
    }

    public function testUnableToCreateNewPageWithSameUrl()
    {
        $this->expectException(\Doctrine\DBAL\Exception\UniqueConstraintViolationException::class);
        /** @var Page $page */
        $page = $this->fixtureRepository->getReference('page');
        $newPage = new Page();
        $newPage->setTemplate($page->getTemplate());
        $newPage->setRouteName('new-route-name');
        $newPage->setUrl($page->getUrl());
        $this->managerRegistry->getManager()->persist($newPage);
        $this->managerRegistry->getManager()->flush();
    }

    public function testUnableToCreateNewPageWithSameSeoBlock()
    {
        $this->expectException(\Doctrine\DBAL\Exception\UniqueConstraintViolationException::class);
        /** @var Page $page */
        $page = $this->fixtureRepository->getReference('page');
        $seoBlock = new Block();
        $seoBlock->setTemplate('path/to/seo/template.html.twig');
        $seoBlock->setName('SEO BLOCK');
        $seoBlock->setType('seo_block');
        $page->setSeoBlock($seoBlock);

        $newPage = new Page();
        $newPage->setTemplate($page->getTemplate());
        $newPage->setRouteName('new-route-name');
        $newPage->setUrl('new-url');
        $newPage->setSeoBlock($seoBlock);
        $this->managerRegistry->getManager()->persist($page);
        $this->managerRegistry->getManager()->persist($newPage);
        $this->managerRegistry->getManager()->flush();
    }
}