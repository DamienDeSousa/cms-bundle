<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Site;


use Dades\CmsBundle\DadesCmsBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class NoIconWithoutSiteTest extends TestCase
{
    private \Twig\Environment $twig;

    public function testGetEmptyIconWithoutSite()
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
                $confDir = $this->getProjectDir().'/tests/fixtures/resources/config';
                $loader->load($confDir . '/doctrine.yaml', 'yaml');
                $loader->load($confDir . '/framework.yaml', 'yaml');
                $loader->load($confDir . '/twig.yaml', 'yaml');
            }

            public function getCacheDir(): string
            {
                return __DIR__ . '/../../../cache/' . spl_object_hash($this);
            }
        };
        $kernel->boot();
        $this->twig = $kernel->getContainer()->get('test.service_container')->get('twig');
    }
}
