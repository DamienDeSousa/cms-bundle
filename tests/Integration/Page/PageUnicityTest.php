<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Page;

use Dades\CmsBundle\DadesCmsBundle;
use Dades\CmsBundle\DataFixtures\ORM\Page\PageUnicityTestFixture;
use Dades\CmsBundle\Entity\Block;
use Dades\CmsBundle\Entity\Page;
use Dades\CmsBundle\Tests\Integration\Block\BlockNameUnicityKernel;
use Dades\TestFixtures\Fixture\FixtureAttachedTrait;
use Dades\TestFixtures\Fixture\FixtureLoaderTrait;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class PageUnicityTest extends TestCase
{
    use FixtureLoaderTrait;

    private ManagerRegistry $managerRegistry;

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

    protected function setUp(): void
    {
        $kernel = new class('test', true) extends Kernel
        {
            use MicroKernelTrait;

            public function __construct(string $environment, bool $debug)
            {
                parent::__construct($environment, $debug);
            }

            public function registerBundles(): iterable
            {
                return [
                    new DadesCmsBundle(),
                    new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
                    new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
                    new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
                    new \Symfony\Bundle\TwigBundle\TwigBundle(),
                ];
            }

            protected function configureRoutes(RouteCollectionBuilder $routes)
            {
            }

            protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
            {
                $confDir = $this->getProjectDir().'/src/Resources/config';
                $loader->load($confDir . '/test/doctrine.yaml', 'yaml');
                $loader->load($confDir . '/test/framework.yaml', 'yaml');
                $loader->load($confDir . '/test/twig.yaml', 'yaml');
            }

            public function getCacheDir(): string
            {
                return __DIR__ . '/../../../cache/' . spl_object_hash($this);
            }
        };
        $kernel->boot();
        $this->managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->loadFixture(
            $this->managerRegistry->getManager(),
            new PageUnicityTestFixture()
        );
    }
}