<?php

/**
 * Defines the RouteLoader class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Routing;

use Dades\CmsBundle\Controller\PageController;
use Dades\CmsBundle\Repository\PageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouteCollection;

/**
 * Loads CMS page route to make it available when Symfony search on of these pages.
 * By default, the Symfony router loads every routes once and then try to match the request and the route.
 * But in our case, we can generate dynamically routes.
 * So when a new route is created, it will not be loaded by the Symfony router.
 * That's why we use here the Symfony CMF component in order to replace the default router by a chain router.
 * To see or create the configuration, go to config/packages/cmf_routing.yaml
 */
class RouteLoader extends PageRepository implements RouteProviderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry);
    }

    public function getRouteCollectionForRequest(Request $request): RouteCollection
    {
        $requestUri = substr($request->getRequestUri(), 1);
        $pages = $this->findBy(['url' => $requestUri]);
        $collection = new RouteCollection();
        foreach ($pages as $page) {
            $route = new Route($page->getUrl(), ['_controller' => PageController::class]);
            $collection->add($page->getRouteName(), $route);
        }

        return $collection;
    }

    public function getRouteByName($name): Route
    {
        $page = $this->findOneBy(['routeName' => $name]);
        if (!$page) {
            throw new RouteNotFoundException("No route found for name '$name'");
        }

        return new Route($page->getUrl());
    }

    public function getRoutesByNames($names): array
    {
        $routes = [];
        if (!$names) {
            return $routes;
        }

        foreach ($names as $name) {
            try {
                $routes[] = $this->getRouteByName($name);
            } catch (RouteNotFoundException $exception) {
                continue;
            }
        }

        return $routes;
    }
}