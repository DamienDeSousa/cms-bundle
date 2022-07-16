<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Functional\Controller;

use Dades\CmsBundle\DadesCmsBundle;
use Dades\CmsBundle\Tests\Functional\Controller;
use Dades\CmsBundle\Entity\Page;
use Dades\TestUtils\Loader\LoadResourceTrait;
use Dades\TestUtils\Runner\RunCommandTrait;
use Dades\TestFixtures\Fixture\FixtureLoaderTrait;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class PageControllerTest extends TestCase
{
    use FixtureLoaderTrait;

    use RunCommandTrait;

    private KernelBrowser $client;

    public function testDisplay404CmsPage()
    {
        $this->client->request('GET', '/unexpected-url');
        $response = $this->client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDisplayCmsPage()
    {
        /** @var Page $page */
        $page = $this->fixtureRepository->getReference('page');
        $this->client->request('GET', $page->getUrl());
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        $kernel = new class('test', true) extends Kernel
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
                    new \Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
                ];
            }

            protected function configureRoutes(RouteCollectionBuilder $routes)
            {
            }

            protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
            {
                $this->loadTwigResource($this->getProjectDir(), $loader);
                $this->loadDoctrineResource($this->getProjectDir(), $loader);
                $this->loadFrameworkResource($this->getProjectDir(), $loader);
                $this->loadCmfRoutingResource($this->getProjectDir(), $loader);
            }

            public function getCacheDir(): string
            {
                return __DIR__ . '/../../../cache/' . spl_object_hash($this);
            }
        };

        $kernel->boot();
        $this->client = new KernelBrowser($kernel);
        $application = new Application($this->client->getKernel());
        $application->setAutoExit(false);
        $this->runCommand(
            $application,
            [
                'command' => 'doctrine:schema:update',
                '--quiet' => true,
                '--force' => true,
            ]
        );
        /** @var ManagerRegistry $registry */
        $registry = $kernel->getContainer()->get('doctrine');
        $this->loadFixture(
            $registry->getManager(),
            new PageControllerTestFixture()
        );
    }
}