<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Routing;

use Dades\CmsBundle\DataFixtures\ORM\Routing\RouteLoaderTestFixture;
use Dades\CmsBundle\Entity\Page;
use Dades\CmsBundle\Routing\RouteLoader;
use Dades\TestFixtures\Fixture\FixtureAttachedTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class RouteLoaderTest extends KernelTestCase
{
    use FixtureAttachedTrait {
        FixtureAttachedTrait::setUp as setUpTrait;
    }

    private RouteLoader $loader;

    protected function setUp(): void
    {
        $this->setUpTrait();
        self::bootKernel();
        $this->loader = self::$kernel->getContainer()->get('test.service_container')->get('cms_dades.page_route_loader');
    }

    protected static function getFixtureNameForTestCase(string $testCaseName): string
    {
        return RouteLoaderTestFixture::class;
    }

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
}