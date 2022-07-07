<?php

/**
 * File that defines the create site command test. This class is used to test the command which creates a new Site.
 * It also tests the impossibility of creating more than one Site.
 *
 * @author Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Site;

use Dades\CmsBundle\DadesCmsBundle;
use Dades\CmsBundle\DataFixtures\ORM\Site\CreateSiteCommandTestFixture;
use Dades\TestUtils\Loader\LoadResourceTrait;
use Dades\CmsBundle\Tests\RunCommandTrait;
use Dades\TestFixtures\Fixture\FixtureLoaderTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class CreateSiteCommandTest extends TestCase
{
    use RunCommandTrait;

    private Kernel $kernel;

    public function testCreateSiteExecute()
    {
        $application = new Application($this->kernel);

        $command = $application->find('cms:site:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'title' => 'site-test-title',
        ]);
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Site created successfully', $output);
    }

    public function testCreateMoreSiteExecute()
    {
        $application = new Application($this->kernel);

        $command = $application->find('cms:site:create');
        $commandTester = new CommandTester($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'title' => 'site-test-title',
        ]);
        $output = $commandTester->getDisplay();

        $commandTester->execute([
            'title' => 'site-test-title-2',
        ]);
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Can\'t create site, a site should already exist', $output);
    }

    protected function setUp(): void
    {
        $this->kernel = new class('test', true) extends Kernel
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
        };

        $this->kernel->boot();
        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $this->runCommand(
            $application,
            [
                'command' => 'doctrine:schema:update',
                '--quiet' => true,
                '--force' => true,
            ]
        );
    }
}
