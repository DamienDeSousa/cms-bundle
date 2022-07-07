<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Site;

use Dades\CmsBundle\DadesCmsBundle;
use Dades\CmsBundle\Tests\Integration\Site\IconSiteTestFixture;
use Dades\CmsBundle\Entity\Site;
use Dades\CmsBundle\Tests\RunCommandTrait;
use Dades\CmsBundle\Twig\Admin\AdminExtension;
use Dades\TestFixtures\Fixture\FixtureAttachedTrait;
use Dades\TestFixtures\Fixture\FixtureLoaderTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class IconSiteTest extends TestCase
{
    use FixtureLoaderTrait;

    use RunCommandTrait;

    private \Twig\Environment $twig;

    private string $uploadPathDir;

    public function testGetIcon()
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        $twigGetIconFunction = $this->twig->getFunction('get_icon');
        $getIcon = $twigGetIconFunction->getCallable();

        $this->assertEquals($this->uploadPathDir . $site->getIcon(), $getIcon());
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
        $this->twig = $kernel->getContainer()->get('test.service_container')->get('twig');
        $this->uploadPathDir = $kernel->getContainer()->getParameter('dades_cms.icon_directory');
        $managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->loadFixture(
            $managerRegistry->getManager(),
            new IconSiteTestFixture()
        );
    }
}