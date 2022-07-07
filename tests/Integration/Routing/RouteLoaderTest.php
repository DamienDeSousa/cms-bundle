<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Routing;

use Dades\CmsBundle\DadesCmsBundle;
use Dades\CmsBundle\Tests\Integration\Routing\RouteLoaderTestFixture;
use Dades\CmsBundle\Entity\Page;
use Dades\CmsBundle\Routing\RouteLoader;
use Dades\CmsBundle\Tests\Integration\Page\PageUnicityKernel;
use Dades\CmsBundle\Tests\LoadResourceTrait;
use Dades\CmsBundle\Tests\RunCommandTrait;
use Dades\TestFixtures\Fixture\FixtureLoaderTrait;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class RouteLoaderTest extends TestCase
{
    use FixtureLoaderTrait;

    use RunCommandTrait;

    private RouteLoader $loader;

    public function testGetRouteByName()
    {
        /** @var Page $page */
        $page = $this->fixtureRepository->getReference('page');
        $route = $this->loader->getRouteByName($page->getRouteName());

        $this->assertEquals(
            sprintf('/%s', $page->getUrl()),
            $route->getPath()
        );
    }

    public function testGetNoRouteByName()
    {
        $this->expectException(RouteNotFoundException::class);
        $this->loader->getRouteByName('unexpected_route_name');
    }

    public function testGetRoutesByNames()
    {
        /** @var Page $page */
        $page = $this->fixtureRepository->getReference('page');
        $routes = $this->loader->getRoutesByNames([$page->getRouteName()]);

        $this->assertEquals(1, count($routes));
    }

    public function testGetNoROutesByNames()
    {
        $routes = $this->loader->getRoutesByNames(['unexpected_route_name']);

        $this->assertEquals(0, count($routes));
    }

    public function testGetRouteCollectionFromRequest()
    {
        /** @var Page $page */
        $page = $this->fixtureRepository->getReference('page');
        $request = new Request(server: ['REQUEST_URI' => '/' . $page->getUrl()]);
        $routes = $this->loader->getRouteCollectionForRequest($request);

        $this->assertEquals(1, $routes->count());
    }

    public function testGetNoRouteCollectionFromRequest()
    {
        $request = new Request(server: ['REQUEST_URI' => '/wrong-uri']);
        $routes = $this->loader->getRouteCollectionForRequest($request);

        $this->assertEquals(0, $routes->count());
    }

    protected function setUp(): void
    {
        $kernel = new class('test', false) extends Kernel
        {
            use MicroKernelTrait;

            use LoadResourceTrait;

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
                $this->loadDoctrineResource($this->getProjectDir(), $loader);
                $this->loadFrameworkResource($this->getProjectDir(), $loader);
                $this->loadTwigResource($this->getProjectDir(), $loader);
            }

            public function getCacheDir(): string
            {
                return __DIR__ . '/../../../cache/' . spl_object_hash($this);
            }

            protected function build(ContainerBuilder $container)
            {
                $container->getCompilerPassConfig()->addPass(new class implements CompilerPassInterface{
                    public function process(ContainerBuilder $container)
                    {
                        $container->getDefinition('cms_dades.page_route_loader')->setPublic(true);
                    }
                }, PassConfig::TYPE_BEFORE_REMOVING);
            }
        };

        $kernel->boot();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $this->runCommand(
            $application,
            [
                'command' => 'doctrine:schema:update',
                '--quiet' => true,
                '--force' => true,
            ]
        );
        $this->managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->loadFixture(
            $this->managerRegistry->getManager(),
            new RouteLoaderTestFixture()
        );
        $this->loader = $kernel->getContainer()->get('cms_dades.page_route_loader');
    }
}
