<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests;

use Symfony\Component\Config\Loader\LoaderInterface;

trait LoadResourceTrait
{
    public function loadTwigResource(string $projectDir, LoaderInterface $loader): void
    {
        $this->loadResource('/twig.php', $loader, $projectDir);
    }

    public function loadDoctrineResource(string $projectDir, LoaderInterface $loader): void
    {
        $this->loadResource('/doctrine.php', $loader, $projectDir);
    }

    public function loadFrameworkResource(string $projectDir, LoaderInterface $loader): void
    {
        $this->loadResource('/framework.php', $loader, $projectDir);
    }

    public function loadCmfRoutingResource(string $projectDir, LoaderInterface $loader): void
    {
        $this->loadResource('/cmf_routing.php', $loader, $projectDir);
    }

    private function loadResource(string $relativeResourcePath, LoaderInterface $loader, string $projectDir): void
    {
        $confDir = $projectDir . '/tests/fixtures/resources/config';
        $loader->load($confDir . $relativeResourcePath, 'php');
    }
}