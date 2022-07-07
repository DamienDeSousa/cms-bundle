<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Site;

use Dades\CmsBundle\DadesCmsBundle;
use Dades\CmsBundle\DataFixtures\ORM\Site\NoIconSiteTextFixture;
use Dades\CmsBundle\Entity\Site;
use Dades\TestFixtures\Fixture\FixtureLoaderTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class NoIconSiteTest extends TestCase
{
    use FixtureLoaderTrait;

    private \Twig\Environment $twig;

    public function testGetEmptyIconFromSite()
    {
        $twigGetIconFunction = $this->twig->getFunction('get_icon');
        $getIcon = $twigGetIconFunction->getCallable();

        $this->assertNull($getIcon());
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
        $this->twig = $kernel->getContainer()->get('test.service_container')->get('twig');
        $managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->loadFixture(
            $managerRegistry->getManager(),
            new NoIconSiteTextFixture()
        );
    }
}
